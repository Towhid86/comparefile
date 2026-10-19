<?php

use App\Http\Controllers\Auth as AUTH;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //             ->name('register');

    // Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AUTH\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AUTH\AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [AUTH\PasswordResetController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [AUTH\PasswordResetController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [AUTH\PasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [AUTH\PasswordController::class, 'store'])->name('password.store');

});

Route::middleware('auth')->group(function () {
    Route::get('verify-email/{id}/{hash}', AUTH\VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [AUTH\VerifyNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::post('logout', [AUTH\AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
