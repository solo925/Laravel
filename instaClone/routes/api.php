<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

Route::prefix('media')->group(function () {
    // Generate a presigned URL to upload a file directly to MinIO
    Route::post('presign', [MediaController::class, 'presignUpload']);

    // Confirm an uploaded object and persist metadata
    Route::post('/', [MediaController::class, 'store']);

    // List current user's media
    Route::get('/', [MediaController::class, 'index']);
});
