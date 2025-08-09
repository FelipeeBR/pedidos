<?php

use App\Http\Controllers\API\V1\LoginController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/users', [UserController::class, 'index']); 
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::post('/logout/{user}', [LoginController::class, 'logout']);
    });
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});
