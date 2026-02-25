<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('book', BookController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('student', StudentDashboardController::class);

        //  TRANSACTION (CRUD LENGKAP)
        Route::resource('transaction', TransactionController::class);

        //  AKSI TAMBAHAN
        Route::post('/transaction/{id}/approve', [TransactionController::class, 'approve'])
            ->name('transaction.approve');

        Route::post('/transaction/{id}/reject', [TransactionController::class, 'reject'])
            ->name('transaction.reject');

        Route::resource('admin/category', CategoryController::class)->names('admin.category');
    });

    // SISWA
    Route::get('/siswa/dashboard', [StudentDashboardController::class, 'dashboardSiswa'])->name('siswa.dashboard');
    Route::get('/siswa/borrow', [StudentDashboardController::class, 'borrowing'])->name('siswa.borrow');
    Route::get('/siswa/return', [StudentDashboardController::class, 'returning'])->name('siswa.return');

    Route::post('/siswa/borrow-action/{id}', [TransactionController::class, 'pinjamBuku'])
        ->name('siswa.borrow.request');

    Route::post('/siswa/return-action/{id}', [TransactionController::class, 'returnBook'])
        ->name('siswa.return.proses');
});
