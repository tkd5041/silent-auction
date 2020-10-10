<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('id', '>', 1)->get();
        return view('admin.events.index')->with('events', $events);
    }

    public function edit(Event $event)
    {
        if(Gate::denies('edit-users'))
        {
            return redirect(route('admin.events.index'));
        }

        return view('admin.events.edit')->with([
            'event' => $event,
        ]);
    }


    public function create() 
    {
        return view('admin.events.create');
    }

    public function store() {

        $event = new Event();

        $event->name = request('name');
        $event->start_date = request('start_date');
        $event->start_time = request('start_time');
        $event->end_date = request('end_date');
        $event->end_time = request('end_time');
        $event->start = request('start_date') . ' ' . request('start_time');
        $event->end = request('end_date') . ' ' . request('end_time');
        $event->active = 0;

        if($event->save()){
             session()->flash('success', $event->name . ' has been created');
        }else{
            session()->flash('error', 'There was an error creating the event');
        }

    return redirect()->route('admin.events.index');
    }

    public function update(Request $request, Event $event)
    {
        $event->name = $request->name;
        $event->start_date = $request->start_date;
        $event->start_time = $request->start_time;
        $event->end_date = $request->end_date;
        $event->end_time = $request->end_time;
        $event->active = $request->active;
        $event->start = request('start_date') . ' ' . request('start_time');
        $event->end = request('end_date') . ' ' . request('end_time');

        if($event->save()){
            $request->session()->flash('success', $event->name . ' has been updated');
        }else{
            $request->session()->flash('error', 'There was an error updating the event');
        }

    return redirect()->route('admin.events.index');
    
    }

    public function destroy(Request $request, Event $event)
    {
        if($event->delete()){
            $request->session()->flash('success', $event->name . ' has been deleted');
        }else{
            $request->session()->flash('error', 'There was an error deleting the event');
        }

        return redirect()->route('admin.events.index');
    }
}
