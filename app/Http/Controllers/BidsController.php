<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auction;
use App\Events;

class BidsController extends Controller
{
    // BIDS
    public function get()
    {
        $bids = Auction::where('event_id', session('selected_event'))->latest()->limit(10)->get();

        return response()->json($bids);
    }
}