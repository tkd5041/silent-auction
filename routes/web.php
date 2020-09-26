<?php

use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/auction/{id}/bid', 'AuctionController@bid')->name('auction.bid');
Route::get('/auction/{id}/edit', 'AuctionController@edit')->name('auction.edit');
Route::get('/auction/{id}', 'AuctionController@index')->name('auction');
Route::get('/admin/donors/search', 'Admin\DonorController@search');
Route::get('/admin/items/search', 'Admin\ItemController@search');
Route::get('/admin/users/search', 'Admin\UsersController@search');
Route::delete('/admin/image-uploads/{id}', 'Admin\ImageController@destroy');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function()
{
    
    Route::resource('/auction','AuctionController');
    Route::resource('/donors','DonorController');
    Route::resource('/events','EventController');
    Route::resource('/image-uploads','ImageController');
    Route::resource('/items','ItemController');
    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);

});
