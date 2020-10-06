<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use Session;
use Stripe;
use App\Event;
use App\Item;

class PayController extends Controller
{
    public function index()
    {
        return view('pay.index');
    }

    public function edit($id)
    {
        $user   = Auth::user();
        $event  = Event::findOrFail($id);
        $items  = Item::where('event_id', session('selected_event'))
                     ->where('current_bidder', $user->id)
                     ->where('sold', 1)
                     ->where('paid', 0)
                     ->get();

        $total  = Item::where('event_id', session('selected_event'))
                     ->where('current_bidder', $user->id)
                     ->where('sold', 1)
                     ->where('paid', 0)
                     ->sum('current_bid');

        
        //dd($event, $items, $total);
        return view('pay.edit',)->with([
            'event' => $event,
            'items' => $items, 
            'total' => $total
            ]);

    }

    public function stripe(Request $request)
    {
        $user   = Auth::user();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
              
        $amount =  request('total');
        $amount *= 100;
        // $amount = (int) $amount;
        // $amount = 2500;
        
        $payment_intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
			'currency' => 'USD',
			'description' => 'PAL Auction',
            'payment_method_types' => ['card'],
		]);
		$intent = $payment_intent->client_secret;
        //dd($payment_intent, $intent, $amount);
		return view('pay.checkout',compact('intent'))->with('amount', $amount);

    }

    public function response($id)
    {
        $event  = Event::findOrFail($id);
        $user = Auth::user();
        $items  = Item::where('event_id', $id)
                     ->where('current_bidder', $user->id)
                     ->where('sold', 1)
                     ->where('paid', 0)
                     ->get();

        //dd($user, $event, $items);
        foreach($items as $item)
        {
            $item->paid = 1;
            $item->save();
        }
        
        return redirect()->back()->with('message', 'Thank You For Your Payment!');
    }

}