<?php

use App\Http\Controllers\Api\V1\RedirectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UrlController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::apiResource('urls', UrlController::class);

    Route::get('redirect/{shortCode}', [RedirectController::class, 'getRedirectInfo']);
});
