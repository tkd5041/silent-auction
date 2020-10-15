<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
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
                            ->orderBy('start')
                            ->get();
        } 
        else 
        {
            $events = Event::where('id','>', 1)
                            ->orderBy('start')
                            ->get();
        }
        //dd($events);
        // if no events are active
        if ($events->isEmpty()) 
        {
            $events = Event::where('id', 1)
                            ->orderBy('start')
                            ->get();
            $firstDate = Carbon::now()->addDays(1)->toDateTimeLocalString();
            //dd($events, $firstDate);
            return view('home')->with([
                'events' => $events,
                'firstDate' => $firstDate,           
                ]);
        }
        $now = Carbon::now();
        $first = Event::where('id','>', 1)
                        ->where('active', 1)
                        ->where('start', '>=', $now )
                        ->first();
        //dd($first);
        if (empty($first)) {
            $firstDate = Carbon::now()->addDays(1)->format('Y-m-d\TH:i:s');
        } else {
            $firstDate = Carbon::parse($first->start)->format('Y-m-d\TH:i:s');
        }              
        //dd($first, $firstDate);
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
