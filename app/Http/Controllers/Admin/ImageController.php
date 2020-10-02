<?php

namespace App\Http\Controllers\Admin;

use App\Images;
use App\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
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
    
    public function store(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $event = session('selected_event');

        if ($request->hasFile('image')) {
            $validated = $request->validate([
                'image' => 'mimes:jpeg,jpeg,png,gif|max:1024',
            ]);
            $basename = Str::random();
            $extension = $request->image->extension();
            $imageName = $basename . '.' . $extension;
            
            $request->image->move(public_path('/images'), $imageName);
            
            Images::create([
                    'event_id' => $event,
                    'item_id' => $item->id,
                    'image' => '/images/' . $imageName,
            ]);

            if ($item->image == '') {
                $item->image = "/images/" . $imageName;
                $item->save();
            }
            Session::flash('success', "Image uploaded successfully!");
            return \Redirect::back();
        }
        abort(500, 'Could not upload image.');
        
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

