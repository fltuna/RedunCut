<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{

    public function return404(string $message = 'Not Found'): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], 404);
    }

    public function return500(string $message = 'Internal Server Error'): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], 500);
    }

    public function return422(string $message = 'Unprocessable Content'): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], 422);
    }

    public function return400(string $message = 'Bad Request'): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], 400);
    }

    public function return410(string $message = 'Gone'): JsonResponse
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
