<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class JsonResponseWrapperHelper
{
    private const SUCCESS_MESSAGE = 'Operation successful';
    private const ERROR_MESSAGE = 'Validation failed';
    private const ERROR_CODE = 'VALIDATION_ERROR';

    public static function SuccessResponse(mixed $data): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data ,
            'message' => self::SUCCESS_MESSAGE,
            'meta' => [
                'page' => 1,
                'per_page' => 10,
                'total' => 100,
                'total_pages' => 5
            ]
        ]);
    }

    public static function ErrorResponse(
        array $error = [],
        ?string $errorMessage = null,
        ?string $errorCode = null,
        int $code = 422
    ): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => [
                'code' => $errorCode ?? self::ERROR_CODE,
                'message' => $errorMessage ?? self::ERROR_MESSAGE,
                'details' => $error
            ],
        ])->setStatusCode($code);
    }
}
