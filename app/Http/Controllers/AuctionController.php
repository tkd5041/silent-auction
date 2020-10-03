<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Event;
use App\Auction;
use App\Item;
use App\Images;

class AuctionController extends Controller
{
    public function index($id)
    {
        
        $event = Event::findOrFail($id);
        $bids = Auction::where('event_id', $id)->latest()->get();
        $items = Item::where('event_id', $id)->get();
        
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
        session(['bids_start' => $event->start_date . 'T' . $event->start_time]);
        session(['bids_end' => $event->end_date . 'T' . $event->end_time]);
        $bids_start = session('bids_start');
        $bids_end = session('bids_end');
        $date_now = Carbon::now()->setTimezone('MST')->toDateTimeLocalString();

        //dd([$event, $bids, $items, $bids_start, $bids_end]);
        return view('auction.index',[
            'event' => $event, 
            'bids' => $bids, 
            'items' => $items,
            'bids_start' => $bids_start,
            'bids_end' => $bids_end,
            'date_now' => $date_now,
        ]);
        
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        
        $images = Images::where('item_id', $id)->get();        
        
        //dd($item, $images);
        return view('auction.edit')->with([
            'item' => $item, 
            'images' => $images
        ]);
    }

    public function bid(Request $request, Item $item)
    {
        $user = Auth::user();
       
        $item = Item::findOrFail(request('id'));
        
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
