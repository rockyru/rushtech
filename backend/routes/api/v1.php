<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ApiUserController;

Route::get('/test', fn () => response()->json(['ok' => true]));


Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('admin')->middleware('role:admin')->group(function() {
        Route::apiResource('users', UserController::class)->except(['create', 'edit']);
        Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk-delete');
    });

    Route::prefix('user')->middleware('role:user')->group(function() {
       Route::get('/profile', [ApiUserController::class, 'getProfile'])->name('user.getProfile');
    });
    

});

