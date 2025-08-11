<?php

use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/users', [UserController::class, 'index']); 
        Route::get('/users/{user}', [UserController::class, 'show']);

        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::put('/orders/{order}', [OrderController::class, 'update']);
        Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
    });
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/users', [UserController::class, 'store']);
});
