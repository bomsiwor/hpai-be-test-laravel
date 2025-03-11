<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ROute for checking app health
Route::get('/hello', function (Request $request) {
    return response()->json([
        'message' => 'Hello, Universe!',
        'data' => "Welcome to this service. You wouldn't found anything interesting here.",
    ]);
});

// Auth
Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login');

    Route::middleware('auth:api')->group(function () {
        // Route::post('refresh-token', 'refreshToken');
        Route::post('logout', 'logout');

        Route::get('me', 'me');
        Route::patch('me', 'update');

        Route::patch('change-password', 'changePassword');
    });
});

// ----  USER ------
Route::controller(UserController::class)
    ->middleware(['auth:api', 'role:admin,super-admin'])
    ->prefix('users')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{model}', 'show');

        Route::post('/', 'store');

        Route::delete('/{model}', 'destroy');
    });

Route::controller(RoleController::class)
    ->middleware(['auth:api', 'role:admin,super-admin'])
    ->prefix('roles')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{model}', 'show');

        Route::post('/', 'store');

        Route::patch('/', 'update');

        Route::delete('/{model}', 'destroy');
    });
