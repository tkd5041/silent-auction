<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Donor;
use App\Item;

class ItemController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'donor' => ['required'],
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'value' => ['required', 'string', 'max:100'],
            'retail_value' => ['required', 'integer'],
            'initial_bid' => ['required', 'integer'],
            'increment' => ['required', 'integer'],
        ]);
    }
    
    public function index()
    {
        $items = Item::where('event_id', session('selected_event'))
                        ->where('id','>',1)
                        ->paginate(15);
        return view('admin.items.index')->with('items', $items);
    }

    public function edit(Item $item)
    {
        $donors = Donor::where('event_id', session('selected_event'))->get();
        //dd([$item, $donors]);
        return view('admin.items.edit')->with([
            'item' => $item, 
            'donors' => $donors
        ]);
    }


    public function create() 
    {
        $donors = Donor::where('event_id', session('selected_event'))
                ->orderBy('name')
                ->get();
        return view('admin.items.create')->with(['donors' => $donors]);
    }

    public function store() {

        $item = new Item();

        $item->event_id = session('selected_event');
        $item->donor_id = request('donor');
        $item->title = request('title');
        $item->description = request('description');
        $item->value = request('value');
        $item->retail_value = request('retail_value');
        $item->initial_bid = request('initial_bid');
        $item->increment = request('increment');
        $item->current_bidder = 0;
        $item->current_bid = 0;
        $item->sold = false;
        $item->paid = false;
        $item->letter_sent = false;
        
        if($item->save()){
             session()->flash('success', $item->title . ' has been created');
        }else{
            session()->flash('error', 'There was an error creating the item');
        }

    return redirect()->route('admin.items.index');
    }

    public function update(Request $request, Item $item)
    {
        $item->event_id = session('selected_event');
        $item->donor_id = request('donor');
        $item->title = request('title');
        $item->description = request('description');
        $item->value = request('value');
        $item->retail_value = request('retail_value');
        $item->initial_bid = request('initial_bid');
        $item->increment = request('increment');

        if($item->save()){
            $request->session()->flash('success', $item->title . ' has been updated');
        }else{
            $request->session()->flash('error', 'There was an error updating the item');
        }

    return redirect()->route('admin.items.index');
    
    }

    public function destroy(Request $request, Item $item)
    {
        if($item->delete()){
            $request->session()->flash('success', $item->title . ' has been deleted');
        }else{
            $request->session()->flash('error', 'There was an error deleting the item');
        }

        return redirect()->route('admin.items.index');
    }

    public function search()
    {
        $search_text = $_GET['search'];

        $items = Item::where('title', 'LIKE', '%'.$search_text.'%')
                   ->orWhere('description', 'LIKE', '%'.$search_text.'%')
                   ->get();
                   return view('/admin/items/search')->with('items', $items);
    
    }
}
