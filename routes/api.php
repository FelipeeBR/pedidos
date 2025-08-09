<?php

use App\Http\Controllers\API\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
   Route::get('/users', [UserController::class, 'index']); 
   Route::get('/users/{user}', [UserController::class, 'show']);
   Route::post('/users', [UserController::class, 'store']);
});
