<?php


namespace Sadegh\Media\Services;


use Illuminate\Support\Facades\Storage;

class videoFileService
{

    public static function upload($file)
    {
        $filename = uniqid();
        $extension = $file->getClientOriginalExtension();
        $dir = 'private\\';
        Storage::putFileAs($dir , $file , $filename . '.' . $extension);

       return ["video" =>  $dir. $filename . '.' . $extension] ;

    }
    
}