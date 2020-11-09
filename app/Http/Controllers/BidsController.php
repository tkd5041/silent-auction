<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auction;
use App\Events;
use App\Item;
use DB;

class BidsController extends Controller
{
    // BIDS
    public function get()
    {
        $bids = Auction::where('event_id', session('selected_event'))->latest()->limit(10)->get();
        
        // $bids = Auction::select('id','event_id','item_id')
        // $bids = DB::table('auctions')
        //             ->where('auctions.event_id', session('selected_event'))
        //             ->join('items', 'items.id', '=', 'auctions.item_id')
        //             ->select('items.*', 'items.increment')
        //             ->latest()
        //             ->get();
        // $items = DB::table('items')
        // ->where('items.event_id', '=', $id)
        // ->LeftJoin('users', 'users.id', '=', 'items.current_bidder')
        // ->select('items.*', 'users.username')
        // ->orderBy('end_time', 'DESC')
        // ->orderBy('title', 'ASC')
        // ->get();
        // dd($bids);
        return response()->json($bids);
    }
}