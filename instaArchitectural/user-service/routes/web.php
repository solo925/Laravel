<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile/{user}', [App\Http\Controllers\ProfileController::class, 'show']);
    Route::put('/profile/{user}', [App\Http\Controllers\ProfileController::class, 'update']);
});


