<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getImages()
    {
        $images=  \App\Image::get();
        return view('image', [
			'images' => $images
		]);
    }
    public function uploadImages(Request $request) {
        $request->validate([
            'images.*' => 'mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $input = $request->all();
        if ($request->file('images')) {
            $images = $request->file('images');
            $i=0;
            //storing multiple images
            foreach ($images as $image) {
                $destinationPath = 'prismImages/';//setting destination path
                $profileImage = 'item'.$i. '-' . time() . '.' . strtolower($image->getClientOriginalExtension());
                $image->move($destinationPath, $profileImage);
                if (isset($input['imageTypeView' . $i])) {
                    $imageType = $input['imageTypeView' . $i];
                } else {
                    $imageType = 'Regular/Slider';
                }
                if (isset($input['imageAltText' . $i])) {
                    $imageText = $input['imageAltText' . $i];
                } else {
                    $imageText = 'Image Alt Text';
                }
                \App\Image::create([
                            'user_id' => 1,
                            'image_path' => "$profileImage",
                            'image_text' => $imageText,
                            'image_type' => $imageType 
                ]);
                $i++;
            }
            return redirect()->route('images')->with('success', 'Images Added successfully');
        }
         return redirect()->route('images')->with('success', 'Images Added successfully');
    }

}
