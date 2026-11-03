<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\PaymentController;

Route::get('/welcome', function () {
    return view('welcome');
});


Route::get('/', function () {
    return view('pages.index');
});


Route::get('/books', [BookController::class, 'index'])->name('books.index');


// Borrow the book


// books


Route::middleware(['auth'])->prefix('books')->name('books.')->group(function () {
    Route::get('/{book}/read', [BookController::class, 'read'])->name('read');
    Route::get('/{book}/borrow', [BorrowingController::class, 'create'])->name('borrow');
    Route::post('/borrow', [BorrowingController::class, 'store'])->name('borrow.store');
});


Route::middleware(['auth'])->prefix('payments')->name('payments.')->group(function () {
    Route::get('/{borrowing}/create', [PaymentController::class, 'create'])->name('create');
    Route::post('/{borrowing}/store', [PaymentController::class, 'store'])->name('store');
});

Route::middleware(['auth', 'admin'])->prefix('payments')->name('payments.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::patch('/{payment}/complete', [PaymentController::class, 'complete'])->name('complete');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/books/manage', [BookController::class, 'manage'])->name('books.manage');

    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');

    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});

// Keep dynamic route parameters after fixed book paths such as /books/manage.
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');







Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
