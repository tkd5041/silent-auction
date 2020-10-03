<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
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

        if(Gate::denies('edit-users'))
        {
            $events = Event::where('id','>', 1)
                            ->where('active', 1)
                            ->orderBy('start_date')
                            ->get();
        } 
        else 
        {
            $events = Event::where('id','>', 1)
                            ->orderBy('start_date')
                            ->get();
        }

        $first = Event::where('id','>', 1)
                        ->where('active', 1)
                        ->first();
                        
        $firstDate = $first->start_date . ' ' . $first->start_time;
        
        $firstEvent = strtotime($firstDate);
        //dd($firstEvent);
        //dd($events, $firstDatet);
        
        return view('home')->with([
            'events' => $events,
            'firstDate' => $firstDate,           
            ]);
    }

    public function show($id){

        $event = Event::findOrFail($id);
        return view('home.show', ['event' => $event]);
    }

    
}
