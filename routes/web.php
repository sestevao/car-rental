<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;

use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/browse-cars', [FrontendController::class, 'cars'])->name('frontend.cars.index');
Route::get('/browse-cars/{car}', [FrontendController::class, 'show'])->name('frontend.cars.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/my-bookings', [FrontendController::class, 'myBookings'])->name('my-bookings');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('cars', CarController::class);
    
    Route::resource('drivers', DriverController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    
    Route::resource('bookings', BookingController::class)->only(['index', 'store', 'edit', 'update']);
    
    Route::get('/bookings/{booking}/payment', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/bookings/{booking}/payment', [PaymentController::class, 'store'])->name('payment.store');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    
    Route::get('/reports/payment-details', [ReportController::class, 'paymentDetails'])->name('reports.payment-details');
    Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
    Route::get('/reports/cars', [ReportController::class, 'carReport'])->name('reports.cars');
    
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
});

require __DIR__.'/auth.php';
