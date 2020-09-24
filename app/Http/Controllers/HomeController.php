<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session('current_event', '');
        session('event_name','');
        $events = Event::where('id','>', 1)
                        ->where('active', 1)
                        ->orderBy('start_date')
                        ->get();
        return view('home')->with('events', $events);
    }

    public function show($id){

        $event = Event::findOrFail($id);
        return view('home.show', ['event' => $event]);
    }

    
}
