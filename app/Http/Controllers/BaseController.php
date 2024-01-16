<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function successResponse($result, $message = 'Success'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => $message,
        ], 200);
    }

    public function errorResponse($error, $errorMessages = [], $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $error,
            'data' => $errorMessages,
        ], $code);
    }

}
