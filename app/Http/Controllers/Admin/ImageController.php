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
                'image' => 'mimes:jpeg,jpeg,png,gif|max:4096',
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

            $images = Images::where('item_id', $id)->first();

            if ($item->image == NULL) {
                $item->image = "/images/" . $imageName;
                $item->save();
                //dd($images, $item);
                $images->main = true;
                $images->save();
            }

            Session::flash('session', "Image uploaded successfully!");
            return \Redirect::back();
        }
        Session::flash('status', "Please choose an image.");
            return \Redirect::back();
        
    }

    public function primary($id)
    {
        // get image and item
        $image_m = Images::findOrFail($id);
        $item = Item::findOrFail($image_m->item_id);
        $images = Images::where('item_id', $item->id)->get();;
        //dd($image, $item, $item->id, $images);

        // set images to false
        foreach($images as $image)
        {
            $image->main = false;
            $image->save(); 
        }

        $image_m->main = true;
        $image_m->save();

        $item->image = $image_m->image;
        $item->save();

        return back()->withInput();        
    }

    public function destroy($id)
    {
        
        //dd($id);
        $image = Images::findOrFail($id);
        $item = Item::findOrFail($image->item_id);
        
        // delete the file
        File::delete([
            public_path($image->image)
        ]);

        // delete default image from items
        $item->image = NULL;
        $item->save();

        // delete record from database
        Images::destroy($id);

        return back();
    }
}