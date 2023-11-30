<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = [], $statusCode = 200): JsonResponse
    {
        return new JsonResponse([
            'status' => 'success',
            'data' => $data,
        ], $statusCode);
    }

    public static function error($message, $statusCode = 400): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }
}
