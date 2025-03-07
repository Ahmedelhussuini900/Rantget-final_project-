<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\RenterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HistoriesController;
use App\Http\Controllers\PaymentsController;

// 🔹 توجيه الصفحة الرئيسية إلى صفحة تسجيل الدخول
Route::get('/', function () {
    return redirect()->route('auth.login');
});

// 🔹 مسارات تسجيل الدخول والتسجيل والخروج
Route::controller(AuthController::class)->group(function () {
    Route::get('/auth', 'showAuthForm')->name('auth.login');
    Route::post('/login', 'login')->name('login.submit');
    Route::get('/login', 'showAuthForm')->name('login');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'registerafter')->name('register.submit');
    Route::post('/logout', 'logout')->name('logout');
});

// 🔹 مسارات لوحة التحكم (تتطلب تسجيل الدخول)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ✅ مسارات المالك (Landlord)
    Route::prefix('landlord')->name('landlord.')->group(function () {
        Route::get('/dashboard', [LandlordController::class, 'index'])->name('dashboard');
        Route::resource('/properties', PropertiesController::class);
    });

    // ✅ مسارات المستأجر (Renter)
    Route::prefix('renter')->name('renter.')->group(function () {
        Route::get('/dashboard', [RenterController::class, 'index'])->name('dashboard'); // تأكد أن `index()` موجودة في RenterController
        Route::post('/rent/{property}', [RenterController::class, 'rentProperty'])->name('rent.property');
    });

});

// ✅ مسارات المشرف (Admin) (تتطلب Middleware `admin`)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{id}/update-role', [AdminController::class, 'updateRole'])->name('updateRole');
    Route::delete('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('deleteUser');
});

// 🔹 اختبار الـ Master Layout
Route::get('/master', function () {
    return view('layout.master');
});

// 🔹 مسارات عامة للمستخدمين
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('properties', PropertiesController::class);
    Route::resource('contracts', ContractsController::class);
    Route::get('/dashboard/landlord', [LandlordController::class, 'index'])->name('dashboard.landlord');
    Route::get('/dashboard/renter', [RenterController::class, 'index'])->name('dashboard.renter');
    Route::get('/dashboard/renter/properties', [RenterController::class, 'show'])->name('rented-properties');
    Route::resource('histories', HistoriesController::class)->only(['index']);
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/{contractId}', [PaymentsController::class, 'showMonths'])->name('months');
                 // Route::get('/{contractId}/{month}/{year}/create', [PaymentsController::class, 'create'])->name('create');
      //  Route::post('/store', [PaymentsController::class, 'store'])->name('store');
    });
});

// 🔹 Define the missing 'properties.show' route
Route::get('/properties/{property}', [PropertiesController::class, 'show'])->name('properties.show');



// Route::resource('histories', HistoriesController::class)->only(['index']);
Route::get('/payments/history', [PaymentsController::class, 'history'])->name('payments.history');
