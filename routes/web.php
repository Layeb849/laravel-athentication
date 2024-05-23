<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use App\Http\Middleware\VerifyMiddleware;
use App\Http\Controllers\UserController as ControllersUserController;

Route::view('/registration', 'page.registration')->name('registration');
Route::view('/login', 'page.login')->name('login');
Route::view('/send-otp', 'page.send-otp')->name('send-otp');
Route::view('/verify-otp', 'page.verify-otp')->name('verify-otp');
Route::view('/reset-pass', 'page.reset-pass')->name('reset-pass');





Route::post('/registration', [UserController::class, 'registration']);
Route::post('/login', [UserController::class, 'login']);


Route::post('/send-otp', [UserController::class, 'sendOtp']);
Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
Route::post('/reset-pass', [UserController::class, 'resetPassword'])->middleware(VerifyMiddleware::class);

Route::view('/email', 'Mail.login')->middleware(VerifyMiddleware::class);



Route::view('/sign-up', 'components.auth.signup');
