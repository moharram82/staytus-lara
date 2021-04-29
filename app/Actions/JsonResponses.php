<?php

namespace App\Actions;

use Illuminate\Support\Facades\URL;

class JsonResponses
{
    public static function sendJsonResponse($status = 'success', $code = 200, $message = '', $data = null) {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'links' => [
                'self' => URL::current()
            ],
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function sendNotFoundResponse() {
        return self::sendJsonResponse('fail', 404, 'Record not found!', null);
    }

    public static function sendValidationResponse($errors) {
        return self::sendJsonResponse('fail', 400, 'Invalid data', $errors);
    }

    public static function sendUnauthorizedResponse() {
        return response()->json([
            'status' => 'fail',
            'code' => 401,
            'links' => [
                'self' => URL::current(),
                'intended' => URL::previous()
            ],
            'message' => 'Unauthorized action! you need to login.'
        ], 401);
    }
}
