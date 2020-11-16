<?php


namespace Sadegh\Category\Responses;


use Illuminate\Http\Response;

class AjaxResponses
{
    public static function successResponses()
    {
        return response()->json(['message'=> 'عملیات با موفقیت انجام گردید.'],Response::HTTP_OK );
    }

    public static function FailedResponse()
    {
        return response()->json(['message'=> 'عملیات موفقیت آمیز نبود!'],Response::HTTP_INTERNAL_SERVER_ERROR );

    }
}