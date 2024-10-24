<?php

use App\Models\Setting;

if(!function_exists('uploadFile')) {
    function uploadFile($file,  $path) {   
        if ($file) {
            $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
            $imagePath = $path . $imageName;
            $file->move(public_path($path), $imageName);

            return $imagePath;
        }

        return null;
    }
}
