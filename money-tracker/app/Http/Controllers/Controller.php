<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Standard API response format
     */
    protected function apiResponse($data = null, $message = null, $status = 200)
    {
        $response = [
            'success' => $status < 400,
            'data' => $data,
            'message' => $message,
            'timestamp' => now()->toISOString()
        ];

        return response()->json($response, $status);
    }

    /**
     * Handle API exceptions
     */
    protected function handleApiException(Request $request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return $this->apiResponse(null, 'Resource not found', 404);
        }

        if ($exception instanceof ValidationException) {
            return $this->apiResponse(null, 'Validation failed', 422);
        }

        // Log the error for debugging
        \Log::error('API Error: ' . $exception->getMessage(), [
            'request' => $request->all(),
            'exception' => $exception
        ]);

        return $this->apiResponse(null, 'Internal server error', 500);
    }
}
