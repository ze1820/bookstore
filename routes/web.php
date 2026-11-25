<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/books/{book:slug}', [ShopController::class, 'show'])->name('books.show');

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author:slug}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('contact.send');


Route::get('/hijab-mentorship', [ApplicationController::class, 'mentorship'])->name('mentorship.show');
Route::post('/hijab-mentorship', [ApplicationController::class, 'sendMentorship'])
    ->middleware('throttle:5,1')->name('mentorship.send');

Route::get('/volunteer', [ApplicationController::class, 'volunteer'])->name('volunteer.show');
Route::post('/volunteer', [ApplicationController::class, 'sendVolunteer'])
    ->middleware('throttle:5,1')->name('volunteer.send');
    
Route::view('/returns', 'static.returns')->name('returns');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';