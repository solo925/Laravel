<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('app');
});

Route::resource('post',PostController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Lightweight health check
Route::get('/health', function () {
    return response()->json([
        'ok' => true,
        'service' => config('app.name'),
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit.form');
    Route::get('/profile/update', [ProfileController::class, 'showUpdate'])->name('profile.update.form');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/delete', [ProfileController::class, 'showDelete'])->name('profile.delete');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
