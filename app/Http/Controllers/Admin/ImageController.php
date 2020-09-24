<?php

namespace App\Http\Controllers\Admin;

use App\Images;
use App\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index()
    {
        
        // $images = Image::latest()->get();
        // return view('images',compact('images'));
        //return view('admin.image-uploads.index');
        
        $images = Images::where('event_id', session('selected_event'))
            ->where('item_id', 1)    
            ->latest()
            ->get();
        //dd($images);
        return view('admin.image-uploads.index', compact('images'));  //->with('images', $images);
    }
    
    public function store(Request $request)
    {
        if ( ! is_dir(public_path('/images'))){
            mkdir(public_path('/images'), 0777);
        }
        $images = Collection::wrap(request()->file('file'));

        $images->each(function($image) {
            $basename = Str::random();
            $original = $basename . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/images'), $original );
           
            Images::create([
                'event_id' => 1,
                'item_id' => 1,
                'image' => '/images/' . $original,

            ]);
        });
    }

    public function destroy(Images $image)
    {
        
                  
        // delete the files
        File::delete([
            public_path($image->image)
        ]);

        // delete record from database
        $image->delete();

        // redirect
        return back()->withInput();
    }
}

