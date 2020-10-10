<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Event;
use App\Auction;
use App\Item;
use App\Users;
use App\Images;
use DB;

class AuctionController extends Controller
{
    public function index($id)
    {
        
        $event = Event::findOrFail($id);
        $bids = Auction::where('event_id', $id)->latest()->get();
        $items = DB::table('items')
                   ->where('items.event_id', '=', $id)
                   ->LeftJoin('users', 'users.id', '=', 'items.current_bidder')
                   ->select('items.*', 'users.username')
                   ->orderBy('title', 'ASC')
                   ->get();
        //dd($items);
        // $items = Item::where('event_id', $id)
        //                ->orderBy('title', 'ASC')
        //                ->get();
        
        if ($bids->isEmpty()) {
            $bids = Auction::where('event_id',1)->get();
        }
        if ($items->isEmpty()) {
            $items = Item::where('event_id',1)->get();
        }
        if ('event_id' == 1){
            return view('auction.index',['event' => $event, 'bids' => $bids, 'items' => $items]);
        }
        
        session(['selected_event' => $id]);
        session(['event_name' => $event->name]);
        session(['bids_start' => $event->start_date . ' ' . $event->start_time]);
        session(['bids_end' => $event->end_date . ' ' . $event->end_time]);
        $bids_start = session('bids_start');
        $bids_end = session('bids_end');
        $dt_now = Carbon::now()->subHours(7)->setTimezone('UTC')->timestamp; //->setTimezone('MST');
        $dt_st = Carbon::parse($bids_start)->timestamp;
        $dt_sp = Carbon::parse($bids_end)->timestamp;
        
        //dd([$event, $bids, $items, $bids_start, $bids_end, $dt_now, $dt_st, $dt_sp]);
        return view('auction.index',[
            'event' => $event, 
            'bids' => $bids, 
            'items' => $items,
            'bids_start' => $bids_start,
            'bids_end' => $bids_end,
            'dt_now' => $dt_now,
            'dt_st' => $dt_st,
            'dt_sp' => $dt_sp,
        ]);
        
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $images = Images::where('item_id', $id)->get();        
        
        $bids_start = session('bids_start');
        $bids_end = session('bids_end');
        $dt_now = Carbon::now()->subHours(7)->setTimezone('UTC')->timestamp; //->setTimezone('MST');
        $dt_st = Carbon::parse($bids_start)->timestamp;
        $dt_sp = Carbon::parse($bids_end)->timestamp;

        // sdd($item, $images);
        return view('auction.edit')->with([
            'item' => $item, 
            'images' => $images,
            'bids_start' => $bids_start,
            'bids_end' => $bids_end,
            'dt_now' => $dt_now,
            'dt_st' => $dt_st,
            'dt_sp' => $dt_sp,
        ]);
    }

    public function bid(Request $request, Item $item)
    {
        $user = Auth::user();
        $event = Event::findOrFail(session('selected_event'));
        $item = Item::findOrFail(request('id'));
        //dd($user, $event, $item);
        $item->current_bid = request('bid');
        $item->current_bidder = $user->id;
        
        $item->save();

        $auction = new Auction;

        $auction->event_id = session('selected_event');
        $auction->item_id = $item->id;
        $auction->user_id = $user->id;
        $auction->title = $item->title;
        $auction->username = $user->username;
        $auction->current_bid = $item->current_bid;

        //dd($auction);
        
        $bids_end = session('bids_end');
        $cur_date = Carbon::now()->subHours(7)->addSeconds(30)->setTimezone('UTC')->toDateTimeString();
        $be_new = Carbon::parse($bids_end)->addSeconds(30)->toDateTimeString();
        //dd($cur_date, $bids_end, $be_new);
        $dt_now = Carbon::now()->subHours(7)->setTimezone('UTC')->timestamp; //->setTimezone('MST');
        $dt_sp = Carbon::parse($bids_end)->timestamp;
        $dt_ben = Carbon::parse($be_new)->timestamp;
        
        //dd($dt_sp, $dt_now, $dt_ben, ($dt_now +30) > $dt_sp && $dt_now < $dt_ben);
        //dd( $dt_ben > $dt_now && $dt_now < $dt_sp);
        
        if (($dt_now +15) > $dt_sp && $dt_now < $dt_ben)
        {
            $old_time = Carbon::parse($bids_end)->toTimeString();
            $new_time = Carbon::parse($be_new)->toTimeString();
            //dd($old_time, $new_time);
            $event->end_time = $new_time;
            $event->save();
            
        }

        if($auction->save()){
            session()->flash('success', 'Bid Submitted');
       }else{
           session()->flash('error', 'There was an error submitting the bid');
       }

       $event = Event::findOrFail(session('selected_event'));
        $bids = Auction::where('event_id', session('selected_event'))->latest()->get();
        $items = Item::where('event_id', session('selected_event'))->get();

        return redirect()->route('auction',['id' => $event, 'bids' => $bids, 'items' => $items]);

    }

    
}
