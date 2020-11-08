<?php


namespace Sadegh\Category\Responses;


use Illuminate\Http\Response;

class AjaxResponses
{
    public static function successResponses()
    {
        return response()->json(['message'=> 'عملیات با موفقیت انجام گردید.'],Response::HTTP_OK );
    }
}