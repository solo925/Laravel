<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $posts = \App\Models\Post::with(['user', 'comments.user'])->latest()->paginate(10);
    return view('dashboard', compact('posts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('posts', App\Http\Controllers\PostController::class);
    Route::resource('comments', App\Http\Controllers\CommentsController::class)
        ->parameters(['comments' => 'comment']);
});

require __DIR__.'/auth.php';

// Test route to check database connection and comments table
Route::get('/test-db', function () {
    try {
        // Test database connection
        DB::connection()->getPdo();
        $database = DB::connection()->getDatabaseName();
        
        // Check if comments table exists
        $tableExists = Schema::hasTable('comments');
        
        // Get comments table columns if it exists
        $columns = [];
        if ($tableExists) {
            $columns = Schema::getColumnListing('comments');
        }
        
        return [
            'database' => $database,
            'connection' => 'Successfully connected to the database',
            'comments_table_exists' => $tableExists ? 'Yes' : 'No',
            'comments_table_columns' => $columns,
        ];
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
            'database' => env('DB_DATABASE', 'Not found'),
            'connection' => 'Failed to connect to the database',
        ];
    }
});
