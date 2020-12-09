<?php


namespace Sadegh\Media\Http\Controllers;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Sadegh\Media\Models\Media;
use Sadegh\Media\Services\MediaFileServiece;

class MediaController extends Controller{

    public function download(Media $media,Request $request)
    {
        if (!$request->hasValidSignature()){
            abort(401);
        }

        return MediaFileServiece::stream($media);


      }

}
