<?php

namespace Garavel\Controller;

use Garavel\Requests\CroppieUploadRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class GaravelCroppieController extends Controller {

    public function __construct()
    {
        $this->middleware(['permission:croppie_upload']);
    }


    public function upload(CroppieUploadRequest $request)
    {

        if (!$request->hasValidSignature())
        {
            abort(401);
        }

        $imageUrl = $request->get('saved_image');

        $configName = $request->get('config_name');
        $croppies = config('croppie');
        $diskConfig = $croppies[$configName];
        $disk = Storage::disk($diskConfig['disk']);


        $imageFullUrl = $disk->url($imageUrl);
        $imageBaseUrl = $diskConfig['path'] . $imageUrl;

        return response()->json([
            'imageFullUrl' => $imageFullUrl,
            'imageBaseUrl' => $imageBaseUrl,
        ]);


    }


}
