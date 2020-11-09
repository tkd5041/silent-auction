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
        $bids = Auction::where('event_id', session('selected_event'))->latest()->get();
        
        return response()->json($bids);
    }
}