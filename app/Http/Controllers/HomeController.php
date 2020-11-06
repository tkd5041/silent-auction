<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Event;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session('current_event', '');
        session('event_name','');

        if(Gate::denies('edit-users'))
        {
            // get active and inactive events for admins
            $events = Event::where('active','=', 1)
                            ->orderBy('start')
                            ->get();
        } 
        else 
        {
            // get only active events for bidders
            $events = Event::where('active','<', 2)
                            ->orderBy('start')
                            ->get();
        }

        // get all closed events for admins and bidders
        $closed = Event::where('active','=', 2)
                            ->orderBy('start', 'desc')
                            ->limit(5)
                            ->get();

        dd($events, $closed);
        return view('home')->with([
            'events' => $events,
            'closed' => $closed,           
            ]);
    }

    // public function show($id){

    //     $event = Event::findOrFail($id);
    //     return view('home.show', ['event' => $event]);
    // }

    
}
