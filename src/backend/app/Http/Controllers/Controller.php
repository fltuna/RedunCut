<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{

    protected function return404(string $message = 'Not Found'): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], 404);
    }

    protected function return500(string $message = 'Internal Server Error'): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], 500);
    }

    protected function return422(string $message = 'Unprocessable Content'): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], 422);
    }

    protected function return400(string $message = 'Bad Request'): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], 400);
    }

    protected function return410(string $message = 'Gone'): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], 410);
    }

    protected function return403(string $message = 'Forbidden'): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], 403);
    }

    protected function isRegistrationEnabled(): bool
    {
        return (bool) config('auth.registration.enabled', false);
    }
}
