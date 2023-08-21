<?php

use App\Http\Controllers\Reader\AlgoliaSearchController;
use App\Http\Controllers\Reader\Auth\LoginController;
use App\Http\Controllers\Reader\Auth\RegisterController;
use App\Http\Controllers\Reader\Auth\VerificationController;
use App\Http\Controllers\Reader\BookController;
use App\Http\Controllers\Reader\DashboardController;
use App\Http\Controllers\Reader\HomeController;
use App\Http\Controllers\Reader\ShelfController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

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
Route::get('/0auth2/{token?}', [VerificationController::class, 'create'])->name('verify');
Route::post('/0auth2/{token?}', [VerificationController::class, 'store']);
Route::post('/0auth1/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth:reader');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('locale/{locale}', [HomeController::class, 'language'])->name('language')->where('locale', '[a-z]+');

Route::controller(BookController::class)
    ->group(function () {
        Route::get('books', 'index')->name('books.index');
        Route::get('book/create', 'create')->name('books.create')->middleware('auth:reader');
        Route::post('book/store', 'store')->middleware('auth:reader');
        Route::get('book/{slug}', 'show')->name('books.show');
        Route::get('book/{slug}/edit', 'edit')->name('books.edit')->middleware('auth:reader');
        Route::patch('book/{slug}/update', 'update')->middleware('auth:reader');
        Route::delete('book/{slug}/delete', 'delete')->name('books.delete')->middleware('auth:reader');
        Route::get('books/{id}/{rating}', 'rate')->name('books.rate')->middleware('auth:reader');
        Route::post('book/{slug}/review_note', 'reviewAndNote')->name('book.review.note')->middleware('auth:reader');
        Route::get('book/{id}/like', 'like')->name('book.like');
    });

Route::get('shelves/{id}/products', [ShelfController::class, 'shelfBooks'])->name('shelves.books');
Route::resource('shelves', ShelfController::class);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('cart', [DashboardController::class, 'cart'])->name('cart');
Route::get('date', [DashboardController::class, 'dateControl'])->name('date');



Route::get('search', [AlgoliaSearchController::class, 'search']);
