<?php

namespace App\Listeners;

use App\Events\NewBid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewBidListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewBid  $event
     * @return void
     */
    public function handle(NewBid $event)
    {
        return $event; 
    }
}
