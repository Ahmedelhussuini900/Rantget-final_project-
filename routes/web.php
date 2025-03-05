<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\RenterController;

// 🔹 Redirect to Login Page
Route::get('/', function () {
    return redirect()->route('auth.signin');
});

// 🔹 Authentication Routes
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth.signin');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'registerafter'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔹 Dashboard Routes (Require Authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('properties', PropertiesController::class);
    Route::resource('contracts', ContractsController::class);


    //  Landlord Routes
    // Route::middleware(['landlord'])->group(function () {

    //     Route::resource('payments', PaymentsController::class);
    // });

    // 🔹 Landlord and Renter Dashboards
    Route::get('/dashboard/landlord', [LandlordController::class, 'index'])->name('dashboard.landlord');
    Route::get('/dashboard/renter', [RenterController::class, 'index'])->name('dashboard.renter');
});

// 🔹 Fix Login Route Conflict
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');

// 🔹 Test Master Layout
Route::get('/master', function () {
    return view('layout.master');
});