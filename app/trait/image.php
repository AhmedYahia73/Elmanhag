<?php

namespace App\trait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait image
{
    // This Trait Aboute Image

    public function upload(Request $request,$fileName = 'image',$directory){
        if($request->has($fileName)){// if Request has a Image
            $uploadImage = new request();
            $imagePath = $request->file($fileName)->store($directory,'public'); // Take Image from Request And Save inStorage;
            return $imagePath;
        }
        return Null;
    }
    // This Trait Aboute file

    public function upload_file(Request $request,$fileName = 'image',$directory){
        if($request->has($fileName)){// if Request has a Image
            $uploadImage = new request();
            $imagePath = $request->file($fileName)->store($directory,'public'); // Take Image from Request And Save inStorage;
            return $imagePath;
        }
        return Null;
    }
    
    public function deleteImage($imagePath){
        // Check if the file exists
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
    
}
