<?php


namespace Sadegh\Media\Models;


use Illuminate\Database\Eloquent\Model;
use Sadegh\Media\Services\MediaFileServiece;

class Media extends Model
{
  protected $casts = [
      'files' => 'json',
  ];

    protected static function booted()
    {
        static::deleting(function ($media){
          MediaFileServiece::delete($media);
        });

    }

    public function getThumbAttribute()
    {
        return MediaFileServiece::thumb($this);
    }

}