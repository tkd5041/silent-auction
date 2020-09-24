<?php

namespace App\Http\Controllers;
use App\Event;
use App\Auction;
use App\Item;


use Illuminate\Http\Request;

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

    
}
