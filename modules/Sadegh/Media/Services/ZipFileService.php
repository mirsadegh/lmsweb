<?php


namespace Sadegh\Media\Services;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Sadegh\Media\Contracts\FileServiceContract;
use Sadegh\Media\Models\Media;
use Sadegh\Media\Services\DefaultFileService;

class ZipFileService extends DefaultFileService implements FileServiceContract
{

    public static function upload(UploadedFile $file, $filename, $dir):array
    {
        Storage::putFileAs($dir , $file , $filename . '.' . $file->getClientOriginalExtension());
        return ["zip" =>   $filename . '.' . $file->getClientOriginalExtension()] ;
    }


}