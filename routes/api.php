<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CharacterController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API v1 Routes
Route::prefix('v1')->middleware('force.json')->group(function () {
    // Authentication
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/logout', [AuthController::class, 'logout'])
        ->middleware(['bearer', 'auth:sanctum']);

    // Protected endpoints
    Route::middleware(['bearer', 'auth:sanctum'])->group(function () {
        // Characters CRUD endpoints
        Route::apiResource('characters', CharacterController::class);

        // Users CRUD endpoints
        Route::apiResource('users', UserController::class);
    });
});
