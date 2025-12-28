<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseWrapperHelper
{
    private const SUCCESS_MESSAGE = 'Operation successful';

    public static function SuccessResponse(mixed $data): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data ,
            'message' => self::SUCCESS_MESSAGE,
            'meta' => [
                'page' => 'Not Implemented',
                'per_page' => 'Not Implemented',
                'total' => 'Not Implemented',
                'total_pages' => 'Not Implemented'
            ]
        ]);
    }

    public static function ErrorResponse(
        int $code,
        array $error = []
    ): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => [
                'code' => strtoupper(Response::$statusTexts[$code]),
                'message' => Response::$statusTexts[$code],
                'details' => $error
            ],
        ])->setStatusCode($code);
    }
}
