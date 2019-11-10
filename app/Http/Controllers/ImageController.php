<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function all()
    {
        // return asset('images/callao.jpg');
        return view('image');
    }

    public function getJson(Request $request)
    {
        $json = $request->json;
        $var = json_decode(
            file_get_contents($request->json->path())
            , true
        );

        $array = [];

        foreach ($var['data'] as $data) {
            array_push($array, $data['path_image']);
        }

        $this->copyImage($array);

        return $array;
        // return storage_path('public');
    }

    public function copyImage($array)
    {
        foreach($array as $path){
            Storage::put($path, \Response::make(File::get($path)));
            // File::copy(asset($path),storage_path('public/images/callao.jpg'));
        }
    }

    public function files($filename)
    {
        $path = storage_path('public/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
