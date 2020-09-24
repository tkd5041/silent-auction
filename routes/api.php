<?php

use App\Http\Controllers\Admin\AuctionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
    Route::get('items/{item}/bids', 'AuctionController@index');

    Route::middleware('auth:api')->group(function(){
        Route::post('items/{item}/bid', 'AuctionController@store');
    });

    Route::post('/images', 'Admin\ImageController@store');
