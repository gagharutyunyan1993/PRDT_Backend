<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ImageController extends Controller
{
    /**
     * @param ImageUploadRequest $request
     * @return string
     */
    public function upload(ImageUploadRequest $request)
    {
        $file = $request->file('img');
        $name = Str::random(10);
        $url = Storage::putFileAs('images',$file, $name . '.' . $file->extension());

        return $url;
    }
}
