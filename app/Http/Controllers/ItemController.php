<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\User;
use DB;

class ItemController extends Controller
{
    // ITEM
    public function get($id)
    {
        $item = DB::table('items')
                    ->where('items.id', '=', $id)
                    ->LeftJoin('users', 'users.id', '=', 'items.current_bidder')
                    ->select('items.*', 'users.username')
                    ->get();

        $id = $item[0]->id;
        $bidder = " " . $item[0]->username . " ";
        $bid = "$" . $item[0]->current_bid . ".00";
        $next = "$" . ($item[0]->current_bid + $item[0]->increment) . ".00";
                    
        //dd($id, $bidder, $bid, $next);
        
        return ['id' => $id, 'bidder' => $bidder, 'bid' => $bid, 'next' => $next];
    }
}