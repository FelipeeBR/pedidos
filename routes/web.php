<?php

use App\Http\Controllers\API\V1\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { 
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::view('/dashboard', 'dashboard');