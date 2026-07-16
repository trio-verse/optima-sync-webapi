<?php

namespace App\Helper\V1;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Send a success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = null, string $message = 'Success', int $code = 200) :JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function response($data = null, string $message, int $code): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }


    // errors responses
    public static function error($errors = null, string $message = 'Error', int $code = 400) : JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];
        if($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    public static function unauthorized(string $message = 'Unauthorized User', int $code = 401)
    {
        return self::error(null, $message, $code);
    }

    public static function forbidden(string $message = 'Forbidden', int $code = 403)
    {
        return self::error(null, $message, $code);
    }

    public static function notFound(string $message = 'Resource Not Found', int $code = 404)
    {
        return self::error(null, $message, $code);
    }

    public static function serverError(string $message = 'Internal Server Error', int $code = 500)
    {
        return self::error(null, $message, $code);
    }
}
