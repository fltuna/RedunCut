<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Illuminate\Session\Middleware\StartSession;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\UrlController;
use App\Http\Controllers\Api\V1\RedirectController;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;


Route::prefix('v1')->middleware([
    EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    StartSession::class,
    AddQueuedCookiesToResponse::class,
])->group(function () {

    Route::get('/csrf-token', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    });

    Route::get('redirect/{shortCode}', [RedirectController::class, 'getRedirectInfo']);

    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResource('urls', UrlController::class);
    });

});
