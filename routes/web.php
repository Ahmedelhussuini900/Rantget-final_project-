<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertiesController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/master', function () {
    return view('layout.master');
});



Route::resource('users', UserController::class);

Route::resource('properties', PropertiesController::class);

