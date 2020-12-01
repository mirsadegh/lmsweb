<?php


namespace Sadegh\Media\Services;


use Illuminate\Support\Facades\Storage;
use Sadegh\Media\Models\Media;

class DefaultFileService
{

    public static function delete(Media $media)
    {
        foreach ($media->files as $file){
            if ($media->is_private){
                Storage::delete('private\\'. $file);
            }else{
                Storage::delete('public\\'. $file);
            }

        }
    }
}