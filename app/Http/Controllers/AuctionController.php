<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Carbon\Carbon;
use App\Event;
use App\Auction;
use App\Item;
use App\User;
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
        session(['bids_start' => $event->start]);
        session(['bids_end' => $event->end]);
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
        $bid = request('bid');
        $min_bid = request('min_bid');
        $cur_bid = request('cur_bid');
        if ($bid < $min_bid)
        {
            Session::flash('error', "The minimum bid is $" . $min_bid . ".00");
            return \Redirect::back();
        } else
        {

        $user = Auth::user();
        $event = Event::findOrFail(session('selected_event'));
        $item = Item::findOrFail(request('id'));
        if($item->current_bidder > 0 )
        {
            $cb = User::findOrFail($item->current_bidder);
            //dd($cb);
        }

        if ($user->id == $item->current_bidder)
        {
            Session::flash('error', "You are the current high bidder at $" . $cur_bid . ".00");
            return \Redirect::back();
        }
        
        // send a mail notification
        if($item->current_bidder > 0)
        {
            $sid    = env( 'TWILIO_SID' );
            $token  = env( 'TWILIO_TOKEN' );
            $client = new Client( $sid, $token );
            $number = $cb->phone;
            $message = "You have been outbid on item " . $item->title . ". https://silent-auction.test/auction/" . $item->id . "/edit";
            //dd($sid, $token, $client, $number, $message);
            $client->messages->create(
                $number,
                [
                    'from' => env( 'TWILIO_FROM' ),
                    'body' => $message,
                ]
            );

            $email = $cb->email;
            $subject = "Pal-Auction Outbid Notice";
            $message = "<html><head><title> pal-auction Outbid Notice </title></head><body>" . 
                $cb->username . "!<br><br>You have been outbid on item:<blockquote><a href='https:pal-auction.org/acution/" . 
                $item->id . "/edit'>" . $item->title . "</a></blockquote>Pal-Auction</body></html>";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <no-reply@pal-auction.org>' . "\r\n";
            //dd($email, $message);
            mail($email,$subject,$message,$headers);
        }
        
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
            
            $item->end_time = $new_time;
            $item->save();
            
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

    public function monitor($id) 
    {
        // get relevent info
        $event = Event::findOrFail($id);
        $bids = Auction::where('event_id', $id)->latest()->get();
        $items = Item::where('event_id', $id)
                    ->where('sold', false)
                    ->orderBy('end_time', 'DESC')
                    ->get();
                
        session(['selected_event' => $id]);
        session(['event_name' => $event->name]);
        session(['bids_start' => $event->start]);
        session(['bids_end' => $event->end]);
        $bids_start = session('bids_start');
        $bids_end = session('bids_end');
        $dt_now = Carbon::now()->subHours(7)->setTimezone('UTC')->timestamp; //->setTimezone('MST');
        $dt_st = Carbon::parse($bids_start)->timestamp;
        $dt_sp = Carbon::parse($bids_end)->timestamp;

        // check if any items are left
        if(!empty($items))
        {
            // check individual timestamps
            foreach($items as $item)
            {
                // if expired mark item as closed
                if($item->end_time >= $dt_now)
                {
                    $item->sold = true;
                    $item->save();
                } 

            }

        } else
        {
            //close auction
            $event->active = 3;
            $event->save();
        }

        $items = DB::table('items')
                   ->where('items.event_id', '=', $id)
                   ->LeftJoin('users', 'users.id', '=', 'items.current_bidder')
                   ->select('items.*', 'users.username')
                   ->orderBy('title', 'ASC')
                   ->get();
        
                
        if ($bids->isEmpty()) {
            $bids = Auction::where('event_id',1)->get();
        }
        if ($items->isEmpty()) {
            $items = Item::where('event_id',1)->get();
        }
        if ('event_id' == 1){
            return view('auction.index',['event' => $event, 'bids' => $bids, 'items' => $items]);
        }
        
        //dd([$event, $bids, $items, $bids_start, $bids_end, $dt_now, $dt_st, $dt_sp]);
        return view('auction.monitor',[
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

        
}