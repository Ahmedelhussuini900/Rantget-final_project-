<?php

use App\Http\Controllers\PropertiesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/master', function () {
    return view('layout.master');
});



Route::resource('users', UserController::class);
Route::get('/properties',PropertiesController::class,'index');
