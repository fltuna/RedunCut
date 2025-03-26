<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UrlController;
use App\Http\Controllers\Api\V1\RedirectController;
use App\Http\Controllers\AuthController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;


Route::prefix('v1')->middleware([
    EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
])->group(function () {

    Route::get('redirect/{shortCode}', [RedirectController::class, 'getRedirectInfo']);

    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResource('urls', UrlController::class);
    });

});
