<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Carbon\Carbon;
use App\Auction;
use App\Images;
use App\Event;
use App\Item;
use App\User;
use DB;


class AuctionController extends Controller
{

// INDEX    
    public function index($id)
    {
        
        $event = Event::findOrFail($id);
        $bids = Auction::where('event_id', $id)->latest()->limit(5)->get();
        $auction_closed = session('auction_closed');
        $items = DB::table('items')
                   ->where('items.event_id', '=', $id)
                   ->LeftJoin('users', 'users.id', '=', 'items.current_bidder')
                   ->select('items.*', 'users.username')
                   ->orderBy('end_time', 'DESC')
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
        //$bids_start = session('bids_start');
        //$bids_end = session('bids_end');
        $bids_start = Carbon::parse(session('bids_start'))->format('Y-m-d\TH:i:s');
        $bids_end = Carbon::parse(session('bids_end'))->format('Y-m-d\TH:i:s');
        $dt_now = Carbon::now()->subHours(7)->setTimezone('UTC')->timestamp; //->setTimezone('MST');
        $dt_st = Carbon::parse($bids_start)->timestamp;
        $dt_sp = Carbon::parse($bids_end)->timestamp;
        
        //dd([$event, $bids, $items, $bids_start, $bids_end, $dt_now, $dt_st, $dt_sp]);
        return view('auction.index',[
            'event' => $event, 
            'bids' => $bids,
            'auction_closed' => $auction_closed, 
            'items' => $items,
            'bids_start' => $bids_start,
            'bids_end' => $bids_end,
            'dt_now' => $dt_now,
            'dt_st' => $dt_st,
            'dt_sp' => $dt_sp,
        ]);
        
    }

 // EDIT
    public function edit($id)
    {
        //dd($id);
        $item = Item::findOrFail($id);
        //dd($item);
        $event = Event::findOrFail(session('selected_event'));
        //dd($item->current_bidder);
        $user = User::where('id', $item->current_bidder)->get();
        //dd($user);
        $images = Images::where('item_id', $id)->get();
        $auction_closed = session('auction_closed');
        
        $bids_start = Carbon::parse(session('bids_start'))->format('Y-m-d\TH:i:s');
        $bids_end = Carbon::parse(session('bids_end'))->format('Y-m-d\TH:i:s');
        $dt_now = Carbon::now()->subHours(7)->setTimezone('UTC')->timestamp; //->setTimezone('MST');
        $dt_st = Carbon::parse($bids_start)->timestamp;
        $dt_sp = Carbon::parse($bids_end)->timestamp;
        
        //dd($event, $item, $user, $images);
        return view('auction.edit', [
            '$event' => $event,
            'item' => $item,
            'auction_closed' => $auction_closed,
            'user' => $user, 
            'images' => $images,
            'bids_start' => $bids_start,
            'bids_end' => $bids_end,
            'dt_now' => $dt_now,
            'dt_st' => $dt_st,
            'dt_sp' => $dt_sp,
            ]);
        }
        
// LIST
    public function list($id)
    {
        $event = Event::findOrFail($id);
        $items = DB::table('items')
                    ->where('items.event_id', '=', $id)
                    ->orderBy('title', 'ASC')
                    ->get();

        // get all the fresh auction time information
        session(['selected_event' => $id]);
        session(['event_name' => $event->name]);
        session(['bids_start' => $event->start]);
        session(['bids_end' => $event->end]);
        $bids_start = Carbon::parse(session('bids_start'))->format('Y-m-d\TH:i:s');
        $bids_end = Carbon::parse(session('bids_end'))->format('Y-m-d\TH:i:s');
        $dt_now = Carbon::now()->subHours(7)->setTimezone('UTC')->timestamp; //->setTimezone('MST');
        $dt_st = Carbon::parse($bids_start)->timestamp;
        $dt_sp = Carbon::parse($bids_end)->timestamp;

        
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

// BID
    public function bid(Request $request, Item $item)
    {
        // get bid request info to check
            $bid = request('bid');
            $min_bid = request('min_bid');
            $cur_bid = request('cur_bid');
            

        // if less than minimum bid reject else record the bid
            if ($bid < $min_bid)
            {
                Session::flash('error', "The minimum bid is $" . $min_bid . ".00");
                return \Redirect::back();
            } else
            {

                // get new bidder, event and item information
                $user = Auth::user();
                $event = Event::findOrFail(session('selected_event'));
                $item = Item::findOrFail(request('id'));

                // check if there is a current bidder, if not get current bidder information -> cb = current bidder
                if($item->current_bidder > 0 )
                {
                    $cb = User::findOrFail($item->current_bidder);
                    //dd($cb);
                }

                // if the new bidder is the same as the current bidder then reject bid
                if ($user->id == $item->current_bidder)
                {
                    Session::flash('error', "You are the current high bidder at $" . $cur_bid . ".00");
                    return \Redirect::back();
                }
                
                // send a text notification to current bidder that they have been outbid. include link to re-bid
                if($item->current_bidder > 0)
                {
                    
                    $sid    = 'ACa86f2ce31eff8fe2c761a70ca6c5a0bf'; //env( 'TWILIO_ACCOUNT_SID' );
                    $token  = 'e6806a43258937da06fb0a1aa355320e'; //env( 'TWILIO_AUTH_TOKEN' );
                    $client = new Client( $sid, $token );

                    $number = $cb->phone;
                    $phone = $client->lookups->v1->phoneNumbers($number)->fetch(["type" => ["carrier"]]);

                    // if number has no error codes then send the message
                    if ( ! $phone->carrier['error_code'] ) {
                        $message = "You have been outbid on item " . $item->title . ". https://pal-auction.org/home to bid again!";
                        //dd($sid, $token, $client, $number, $message);
                        $client->messages->create(
                            $number,
                            [
                                'from' => '+15206000725',env( 'TWILIO_FROM' ),
                                'body' => $message,
                            ]
                        );

                    }
                }

                // send a mail notification to current bidder that they have been outbid. include link to re-bid
                    // $email = $cb->email;
                    // $subject = "Pal-Auction Outbid Notice";
                    // $message = "<html><head><title> pal-auction Outbid Notice </title></head><body>" . 
                    // $cb->username . "!<br><br>You have been outbid on item:<blockquote><a href='https:pal-auction.org/auction/" . 
                    // $item->id . "/edit'>" . $item->title . "</a></blockquote>Pal-Auction</body></html>";
                    // $headers = "MIME-Version: 1.0" . "\r\n";
                    // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    // $headers .= 'From: <no-reply@pal-auction.org>' . "\r\n";
                    // //dd($email, $message);
                    // mail($email,$subject,$message,$headers);
            }
                
                $dt_now = Carbon::now()->subHours(7)->setTimezone('UTC')->timestamp; //->setTimezone('MST');
                $item_sp = Carbon::parse($item->end_time)->timestamp;

            
                // update item with new bidder and bid amount
                    $item->current_bid = request('bid');
                    $item->current_bidder = $user->id;
                    $item->save();
            
                // add a new auction entry
                    $auction = new Auction;
                    $auction->event_id = session('selected_event');
                    $auction->item_id = $item->id;
                    $auction->user_id = $user->id;
                    $auction->title = $item->title;
                    $auction->username = $user->username;
                    $auction->current_bid = $item->current_bid;

            
            
            // get dates to check in case its within 30 seconds of the end of the auction        
                // $bids_start = Carbon::parse(session('bids_start'))->format('Y-m-d\TH:i:s');
                // $bids_end = Carbon::parse(session('bids_end'))->format('Y-m-d\TH:i:s');
                // $cur_date = Carbon::now()->subHours(7)->addSeconds(30)->setTimezone('UTC')->toDateTimeString();
                // $be_new = Carbon::parse($bids_end)->addSeconds(30)->format('Y-m-d\TH:i:s');//->toDateTimeString();
                // //dd($cur_date, $bids_end, $be_new);
                // $dt_now = Carbon::now()->subHours(7)->setTimezone('UTC')->timestamp; //->setTimezone('MST');
                // $dt_sp = Carbon::parse($bids_end)->timestamp;
                // $dt_ben = Carbon::parse($be_new)->timestamp;
                
                //dd($dt_sp, $dt_now, $dt_ben, ($dt_now +15) > $dt_sp && $dt_now < $dt_ben);
                //dd( $dt_ben > $dt_now && $dt_now < $dt_sp);
        

        
        
            // if bid is within 30 seconds then add 30 seconds to that item and reset timer by 30 seconds
            //if (($dt_now +15) > $dt_sp && $dt_now < $dt_ben)
            //{
                //     $old_time = Carbon::parse($bids_end)->toTimeString();
                //     $new_time = Carbon::parse($be_new)->toTimeString();
                //     $event->end = $be_new;
                //     $event->save();
            
                // // update individual item by 30 seconds
                //     $item->end_time = $be_new;
                //     $item->save();
                    
            //}

            // save auction and notify bidder of successful bid
            if($auction->save()){
                $bids = Auction::where('event_id', session('selected_event'))->latest()->limit(10)->get();
                //$items = Item::where('event_id', session('selected_event'))->get();
                //broadcast(new NewBid($bids))->toOthers();
                session()->flash('success', 'Your Bid Was Submitted Successfully');
            }else{
                session()->flash('error', 'There was an error submitting your bid');
            }
            
            // get latest information and return to auction index with fresh data
            $event = Event::findOrFail(session('selected_event'));
            // $bids = Auction::where('event_id', session('selected_event'))->latest()->get();
            $items = Item::where('event_id', session('selected_event'))->get();

            return redirect()->route('auction',['id' => $event, 'items' => $items]);
           
    }

// MONITOR
    public function monitor($id) 
    {
    // this is similar to the index but it is just to monitor the closing of the auction and update the event and item information    
    // get relevent info
        $event = Event::findOrFail($id);
        $bids = Auction::where('event_id', $id)->latest()->get();
        $auction_closed = session('auction_closed');

    // get only the items that have not sold yet !important for end of auction!
        $items = Item::where('event_id', $id)
                    ->where('sold', 0)
                    ->orderBy('end_time', 'DESC')
                    ->get();
         
    // get all the fresh auction time information
        session(['selected_event' => $id]);
        session(['event_name' => $event->name]);
        session(['bids_start' => $event->start]);
        session(['bids_end' => $event->end]);
        $bids_start = Carbon::parse(session('bids_start'))->format('Y-m-d\TH:i:s');
        $bids_end = Carbon::parse(session('bids_end'))->format('Y-m-d\TH:i:s');
        $dt_now = Carbon::now()->subHours(7)->setTimezone('UTC')->timestamp; //->setTimezone('MST');
        $dt_st = Carbon::parse($bids_start)->timestamp;
        $dt_sp = Carbon::parse($bids_end)->timestamp;
        if($dt_now > $dt_sp)
        {
            session(['auction_closed' => 1 ]);
        } else if($dt_now < $dt_st)
        {
            session(['auction_closed' => 2 ]);
        }else
        {
            session(['auction_closed' => 0 ]);
        }
        //dd([$event, $bids, $items, $bids_start, $bids_end, $dt_now, $dt_st, $dt_sp, session('auction_closed'), ($dt_now > $dt_sp), ($dt_now < $dt_st) ]);
        
        // check if any items are left
        if(!$items->isEmpty())
        {
            // check individual timestamps and close them if they are expired
            foreach($items as $item)
            {
                $item_end = Carbon::parse($item->end_time)->timestamp;
                //dd($item_end, $dt_now, $dt_now >= $item_end);
                // if expired mark item as sold
                if($dt_now >= $item_end)
                {
                    if($item->current_bidder == 0 )
                    {
                        $item->sold = 2; // not sold but not for sale anymore
                    }
                    else
                    {
                        $item->sold = 1;

                    }

                    $item->save();
                } 

            }

        } 

    //close auction if the item set is empty
            $items = Item::where('event_id', $id)
                    ->where('sold', 0)
                    ->get();

                       
            //dd($items);
            if($items->isEmpty())
            {
                $event = Event::findOrFail($id);
                if ($event->active == 1)
                {
                    $event->active = 2;
                    $event->save();
                }  
                
                $items = Item::where('event_id', $id)
                ->where('sold', 1)
                ->where('texted', 0)
                ->get();
                //dd($items);

                foreach($items as $item)
                {
                    // mark text sent
                    $item->texted = 1;
                    $item->save();
                    
                    // Text the winner
                    $cb = User::findOrFail($item->current_bidder);
                    $sid    = 'ACa86f2ce31eff8fe2c761a70ca6c5a0bf'; //env( 'TWILIO_ACCOUNT_SID' );
                    $token  = 'e6806a43258937da06fb0a1aa355320e'; //env( 'TWILIO_AUTH_TOKEN' );
                    $client = new Client( $sid, $token );
                    $number = $cb->phone;
                    $message = "Congratulations! You have won " . $item->title . " for $" . $item->current_bid . ".00! Please visit https://pal-auction.org/home to pay. Thank you for your support!";

                    $phone = $client->lookups->v1->phoneNumbers($number)->fetch(["type" => ["carrier"]]);

                    // if number has no error codes then send the message
                    if ( ! $phone->carrier['error_code'] ) 
                    {
                        $client->messages->create(
                            $number,
                            [
                                'from' => '+15206000725', //env( 'TWILIO_FROM' ),
                                'body' => $message,
                            ]
                        );
                    }
                }
            }

    // get fresh information on the bids to send back to the index page
        $items = DB::table('items')
                   ->where('items.event_id', '=', $id)
                   ->LeftJoin('users', 'users.id', '=', 'items.current_bidder')
                   ->select('items.*', 'users.username', 'users.name')
                   ->orderBy('sold', 'ASC')
                   ->orderBy('paid', 'DESC')
                   ->orderBy('current_bid', 'DESC')
                   ->orderBy('title', 'ASC')
                   ->get();
        //dd($items);                         
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
            'auction_closed' => $auction_closed,
            'bids_start' => $bids_start,
            'bids_end' => $bids_end,
            'dt_now' => $dt_now,
            'dt_st' => $dt_st,
            'dt_sp' => $dt_sp,
        ]);
    }
}