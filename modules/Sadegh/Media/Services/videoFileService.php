<?php


namespace Sadegh\Media\Services;


use Illuminate\Support\Facades\Storage;
use Sadegh\Media\Contracts\FileServiceContract;
use Sadegh\Media\Models\Media;

class videoFileService extends DefaultFileService implements FileServiceContract
{

    public static function upload($file,$filename,$dir) :array
    {

        $extension = $file->getClientOriginalExtension();
        $dir = 'private\\';
        Storage::putFileAs($dir , $file , $filename . '.' . $extension);

       return ["video" =>   $filename . '.' . $extension] ;

    }

    public static function thumb(Media $media)
    {
        return url('/img/video-thumb.png');
    }


}