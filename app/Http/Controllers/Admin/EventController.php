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
        $event->start = Carbon::parse($event->start)->format('m-d-Y h:i');
        $event->end = Carbon::parse($event->end)->format('m-d-Y h:i');
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
        $event->start = request('start');
        $event->end = request('end');
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
        $event->start = request('start');
        $event->end = request('end');

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
