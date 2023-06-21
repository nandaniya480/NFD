<?php

namespace App\Http\Traits;

trait WebResponseTrait
{
    public function sendResponse($success, $result, $message)
    {
        $response = [
            'success' => $success,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }
}
