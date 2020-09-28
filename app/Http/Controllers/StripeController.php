<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Item;
use Session;
use Stripe;

class StripeController extends Controller
{
    public function stripe()
    {
        $user = Auth::user();
        $items = Item::where('event_id', session('selected_event'))
                     ->where('current_bidder', $user->id)
                     ->where('sold', 1)
                     ->get();

        $total = Item::where('event_id', session('selected_event'))
                     ->where('current_bidder', $user->id)
                     ->where('sold', 1)
                     ->sum('current_bid');

        
        //dd($items, $total);
        return view('stripe/stripe', ['items' => $items, 'total' => $total]);
    }

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "PAL Silent Auction" 
        ]);
  
        Session::flash('success', 'Payment successful!');
          
        return back();
    }
}
