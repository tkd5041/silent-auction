<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Donor;

class DonorController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'tel', 'max:15'],
        ]);
    }
    
    public function index()
    {
        $donors = Donor::where('event_id', session('selected_event'))
                            ->where('id', '>', 1)
                            ->paginate(15);

        dd($donors, session('selected_event'));
        return view('admin.donors.index')->with('donors', $donors);
    }

    public function edit(Donor $donor)
    {
        if(Gate::denies('edit-users'))
        {
            return redirect(route('login'));
        }

        return view('admin.donors.edit')->with([
            'donor' => $donor,
        ]);
    }


    public function create() 
    {
        return view('admin.donors.create');
    }

    public function store() {

        $donor = new Donor();

        $donor->name = request('name');
        $donor->email = request('email');
        $donor->phone = request('phone');
        $donor->event_id = session('selected_event');
        

        if($donor->save()){
             session()->flash('success', $donor->name . ' has been created');
        }else{
            session()->flash('error', 'There was an error creating the donor');
        }

    return redirect()->route('admin.donors.index');
    }

    public function update(Request $request, Donor $donor)
    {
        $donor->name = request('name');
        $donor->email = request('email');
        $donor->phone = request('phone');
        $donor->event_id = session('selected_event');

        if($donor->save()){
            $request->session()->flash('success', $donor->name . ' has been updated');
        }else{
            $request->session()->flash('error', 'There was an error updating the donor');
        }

    return redirect()->route('admin.donors.index');
    
    }

    public function destroy(Request $request, Donor $donor)
    {
        if($donor->delete()){
            $request->session()->flash('success', $donor->name . ' has been deleted');
        }else{
            $request->session()->flash('error', 'There was an error deleting the donor');
        }

        return redirect()->route('admin.donors.index');
    }

    public function search()
    {
        $search_text = $_GET['search'];

        $donors = Donor::where('name', 'LIKE', '%'.$search_text.'%')
                   ->orWhere('email', 'LIKE', '%'.$search_text.'%')
                   ->orWhere('phone', 'LIKE', '%'.$search_text.'%')
                   ->get();
                   return view('/admin/donors/search')->with('donors', $donors);
    
    }
}
