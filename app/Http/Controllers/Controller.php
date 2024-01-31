<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function uploadImage($file, $folder)
    {
        $filename = $file->hashName();
        $path = $file->storePubliclyAs('public/photos/1/' . $folder, $filename);
        return Storage::url($path);
    }
 
}
