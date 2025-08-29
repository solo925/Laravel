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

// Deep health check: verifies DB and Redis
Route::get('/health/deep', function () {
    $checks = [
        'db' => false,
        'redis' => false,
    ];
    try {
        \Illuminate\Support\Facades\DB::select('select 1');
        $checks['db'] = true;
    } catch (\Throwable $e) {
        $checks['db_error'] = $e->getMessage();
    }
    try {
        $pong = \Illuminate\Support\Facades\Redis::connection()->ping();
        $checks['redis'] = (strtoupper((string)$pong) === 'PONG');
    } catch (\Throwable $e) {
        $checks['redis_error'] = $e->getMessage();
    }
    return response()->json([
        'ok' => $checks['db'] && $checks['redis'],
        'service' => config('app.name'),
        'checks' => $checks,
    ], ($checks['db'] && $checks['redis']) ? 200 : 503);
});
