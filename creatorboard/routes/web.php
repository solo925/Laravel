<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CurrentTeamController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Teams Routes
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');

    // switchcing teams
    Route::post('/teams/switch', [CurrentTeamController::class, 'update'])->name('teams.switch');

    // deleting teams
    Route::delete('/teams/{team}', [CurrentTeamController::class, 'destroy'])->name('teams.destroy');

    // Projects Routes
    Route::resource('projects', ProjectController::class);

    // tasks Routes
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/auth.php';
