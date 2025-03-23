<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'index',
    ]);
});



Route::fallback(static function() {
    return response()->json([
        'message' => 'Not Found',
    ], 404);
});
