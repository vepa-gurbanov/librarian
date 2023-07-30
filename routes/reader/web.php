<?php

use App\Http\Controllers\Reader\Auth\LoginController;
use App\Http\Controllers\Reader\Auth\RegisterController;
use App\Http\Controllers\Reader\Auth\VerificationController;
use App\Http\Controllers\Reader\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Reader Routes
|--------------------------------------------------------------------------
|
| Here is where you can register reader routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "reader" middleware group. Make something great!
|
*/

Route::get('/0auth', [RegisterController::class, 'create'])->name('register');
Route::post('/0auth', [RegisterController::class, 'store']);
Route::get('/0auth1', [LoginController::class, 'create'])->name('login');
Route::post('/0auth1', [LoginController::class, 'store']);
Route::post('/0auth2r/{token}', [VerificationController::class, 'resend'])->name('resend');
Route::get('/0auth2/{token}', [VerificationController::class, 'create'])->name('verify');
Route::post('/0auth2/{token}', [VerificationController::class, 'store']);

Route::get('/', [HomeController::class, 'index'])->name('home');
