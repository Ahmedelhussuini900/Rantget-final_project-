<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');


//routes for auth
Route::get('/auth/register', [AuthController::class, 'signup'])->name('auth.signup');

Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');

Route::get('/auth/login', [AuthController::class, 'signin'])->name('auth.signin');

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
