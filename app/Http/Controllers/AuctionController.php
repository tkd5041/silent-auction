<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Event;
use App\Auction;
use App\Item;
use App\User;
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
        //dd([$event, $bids, $items]);
        return view('auction.index',['event' => $event, 'bids' => $bids, 'items' => $items]);
        
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        
        $images = Images::where('item_id', $id)->get();
        
        return view('auction.edit')->with([
            'item' => $item, 
            'images' => $images
        ]);
    }

    public function bid(Request $request, Item $item)
    {
        $auction = new Auction;
        $item = Item::where('$id', $item)->get();

        $auction->event_id = session('selected_event');
        $auction->item_id = $item->id;
        $auction->user_id = Auth::user('id');
        $auction->username = Auth::user('username');
        $auction->current_bid = $request('bid');
        
        if($auction->save()){
            session()->flash('success', 'Bid Submitted');
       }else{
           session()->flash('error', 'There was an error submitting the bid');
       }

        $item->current_bidder = Auth::user('id');
        $item->current_bid = $request('bid');

        $item->save();

        $event = Event::findOrFail(session('selected_event'));
        $bids = Auction::where('event_id', session('selected_event'))->latest()->get();
        $items = Item::where('event_id', session('selected_event'))->get();

        return view('auction.index',['event' => $event, 'bids' => $bids, 'items' => $items]);

    }

    
}
