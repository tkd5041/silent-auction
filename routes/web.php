<?php

use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('event',function(){
    event(new NewBid('Hey how are you!'));
});

Route::get('/bids', 'BidsController@get')->middleware('auth');
Route::post('/bids', 'BidsController@get')->middleware('auth');
Route::get('/item/{id}', 'ItemController@get')->middleware('auth');
Route::post('/item', 'ItemController@get')->middleware('auth');


Route::view('/bulksms', 'bulksms')->middleware('can:manage-users')->name('sms.index');
Route::post('/bulksms', 'BulkSmsController@sendSms')->middleware('auth');

Route::get('/pay/{id}/edit', 'PayController@edit')->middleware('auth')->name('pay.edit');
Route::get('/pay/{id}/response', 'PayController@response')->middleware('auth')->name('pay.response');
Route::get('/pay/checkout', 'PayController@checkout')->middleware('auth')->name('pay.checkout');
Route::post('/pay/stripe', 'PayController@stripe')->middleware('auth')->name('pay.stripe');
Route::get('/pay', 'PayController@index')->name('pay.index');

Route::put('/auction/{id}/bid', 'AuctionController@bid')->middleware('auth')->middleware('auth')->name('auction.bid');
Route::get('/auction/{id}/edit', 'AuctionController@edit')->middleware('auth')->name('auction.edit');
Route::get('/auction/{id}/list', 'AuctionController@list')->middleware('can:manage-users')->middleware('auth')->name('auction.list');
Route::get('/auction/{id}/monitor', 'AuctionController@monitor')->middleware('can:manage-users')->middleware('auth')->name('auction.monitor');
Route::get('/auction/{id}', 'AuctionController@index')->middleware('auth')->name('auction');

Route::get('/admin/donors/search', 'Admin\DonorController@search');
Route::get('/admin/items/search', 'Admin\ItemController@search');
Route::get('/admin/users/search', 'Admin\UsersController@search');

Route::get('/admin/image-uploads/{id}/mp', 'Admin\ImageController@primary')->name('image.primary');
Route::get('/admin/image-uploads/{id}/edit', 'Admin\ImageController@index')->name('image.upload');
Route::post('/admin/image-uploads/{id}/edit', 'Admin\ImageController@store')->name('image.add');
Route::delete('/admin/image-uploads/{id}', 'Admin\ImageController@destroy')->name('image.destroy');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function()
{
    
    Route::resource('/auction','AuctionController');
    Route::resource('/donors','DonorController');
    Route::resource('/events','EventController');
    Route::resource('/image-uploads','ImageController');
    Route::resource('/items','ItemController');
    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);

});
