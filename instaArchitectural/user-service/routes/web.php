<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;



// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile/{email}', [App\Http\Controllers\ProfileController::class, 'show']);
    Route::put('/profile/{id}', [App\Http\Controllers\ProfileController::class, 'update']);
});


