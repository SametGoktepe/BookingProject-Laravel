<?php

use Illuminate\Http\Request;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ForgotPasswordController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/verify-pin', 'verifyPin');
    Route::post('/reset-password', 'resetPassword');
});

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::get('/me', 'me')->name('me');
        Route::post('/add-address', 'addAddress')->name('add-address');
        Route::post('/verify-email', 'verifyEmail')->name('verify-email');
        Route::post('/resend-email', 'resendEmail')->name('resend-email');
        Route::prefix('{user_id}')->group(function () {
            Route::post('/', 'update')->name('update');
            Route::get('/', 'show')->name('show');
            Route::delete('/', 'destroy')->name('destroy');
            Route::post('/update-password', 'updatePassword')->name('password-reset');
            Route::prefix('{address_id}')->group(function () {
                Route::post('/', 'updateAddress')->name('update-address');
            });
        });
    });
});
