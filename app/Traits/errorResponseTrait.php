<?php

namespace App\Traits;

trait errorResponseTrait
{

    public function errorResponse($message, $errorMessage, $statusCode)
    {
        return response()->json([
            'status'       => $statusCode,
            'message'      => $message,
            'errorMessage' => $errorMessage
        ], $statusCode);
    }
}
