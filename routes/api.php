<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
// CRUD users
// Route::get('users', [UserController::class, 'index']);
// Route::post('users', [UserController::class, 'store']);
// Route::get('users/{user}', [UserController::class, 'show']);
// Route::put('users/{user}', [UserController::class, 'update']);
// Route::delete('users/{user}', [UserController::class, 'destroy']);

    // Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
    Route::apiResource('users', UserController::class);
});


// Auth
Route::prefix('v1/auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

    // Route::middleware(['auth:sanctum'])->group(function () {
    //     Route::get('profile', [AuthController::class, 'profile']);
    //     Route::post('logout', [AuthController::class, 'logout']);
    // });

    // Route::group(['middleware' => ['auth:sanctum']], function () {
    //     Route::get('profile', [AuthController::class, 'profile']);
    //     Route::post('logout', [AuthController::class, 'logout']);
    // });
});
