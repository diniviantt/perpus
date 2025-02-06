<?php

use App\Http\Controllers\ArtisanCallController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/artisan-down', [ArtisanCallController::class, 'down']);
    Route::get('/artisan-up', [ArtisanCallController::class, 'up']);
    Route::get('/artisan-optimize', [ArtisanCallController::class, 'optimize']);
});
