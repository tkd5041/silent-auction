<?php

namespace App\Http\Controllers\Admin;

use App\Images;
use App\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


//use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index($id)
    {
        $item = Item::findOrFail($id);
        $event = session('selected_event');
        $images = Images::where('event_id', $event)
                        ->where('item_id', $id)
                        ->get();
        //dd($images, $item);
        return view('admin.image-uploads.index')->with([
            'images' => $images,
            'item' => $item,
        ]);
    }
    
    public function store(Request $request)
    {
        $image = $request->file('file');

        $basename = Str::random();
        $imageName = $basename . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName );
        return response()->json(['success'=>$imageName]);


        
        // console.log($item);
        // if ( ! is_dir(public_path('/images'))){
        //     mkdir(public_path('/images'), 0755);
        // }
        // $images = Collection::wrap(request()->file('file'));

        // $images->each(function($image) {
        //     $basename = Str::random();
        //     $original = $basename . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('/images'), $original );
           
        //     Images::create([
        //         'event_id' => 3,
        //         'item_id' => 1,
        //         'image' => '/images/' . $original,

        //     ]);
        // });
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

    public function dropzone() 
    {
        return view('image.upload');
    }
}

