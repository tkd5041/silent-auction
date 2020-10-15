<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Role;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id','>',1)->paginate(15);
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Gate::denies('edit-users'))
        {
            return redirect(route('admin.users.index'));
        }
        
        $roles = Role::all();

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if($user->save()){
            $request->session()->flash('success', $user->name . ' has been updated');
        }else{
            $request->session()->flash('error', 'There was an error updating the user');
        }

    return redirect()->route('admin.users.index');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
               
        $user->roles()->detach();
        if($user->delete()){
            $request->session()->flash('success', $user->name . ' has been deleted');
        }else{
            $request->session()->flash('error', 'There was an error deleting the user');
        }

        return redirect()->route('admin.users.index');
    }

    public function search()
    {
        $search_text = $_GET['search'];

        $users = User::where('name', 'LIKE', '%'.$search_text.'%')
                   ->orWhere('email', 'LIKE', '%'.$search_text.'%')
                   ->orWhere('phone', 'LIKE', '%'.$search_text.'%')
                   ->get();
                   return view('/admin/users/search')->with('users', $users);
    
    }
}
