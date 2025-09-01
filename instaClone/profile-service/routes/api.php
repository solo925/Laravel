<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Public: fetch profile by username
Route::get('/profiles/{username}', [ProfileController::class, 'show']);

// Temporary authenticated: upsert own profile via header X-User-Id (to be replaced by Sanctum)
Route::post('/profiles', [ProfileController::class, 'upsert']);
