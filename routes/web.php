<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\OTPVerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('welcome');
});


// user all route
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/verify-otp', [UserController::class, 'verifyOTP'])->name('verify.otp');
Route::post('/resend-otp', [UserController::class, 'resendOTP'])->name('resend.otp');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

    // user checkout
    Route::get('/product/checkout/{id}', [CheckoutController::class, 'checkout'])->name('product.checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    // PayPal Success and Cancel Routes
    Route::get('/paypal/success', [CheckoutController::class, 'success'])->name('paypal.success');
    Route::get('/paypal/cancel', [CheckoutController::class, 'cancel'])->name('paypal.cancel');
    Route::get('/order/success', [CheckoutController::class, 'successOrder'])->name('order.success');

});

// admin all route
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // PayPal settings route
    Route::get('/paypal-settings', [AdminController::class, 'showPayPalSettings'])->name('paypal-settings');
    Route::put('/paypal-settings', [AdminController::class, 'updatePayPalSettings'])->name('paypal-settings.update');

    // Logout route
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
});

