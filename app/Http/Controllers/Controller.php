<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function Response($statusCode, $data, $message = null) {
        return response()->json([
            'success' => boolval($statusCode == 200),
            'statusCode' => $statusCode,
            'message' => $message ?? self::getDefaultMessage($statusCode),
            'data' => $data,
        ], $statusCode);
    }

    public static function getDefaultMessage(int $statusCode) {
        return trans("httpmessages.$statusCode");
    }
}
