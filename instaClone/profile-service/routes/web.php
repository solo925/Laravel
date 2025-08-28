<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Lightweight health check
Route::get('/health', function () {
    return response()->json([
        'ok' => true,
        'service' => config('app.name'),
    ]);
});
