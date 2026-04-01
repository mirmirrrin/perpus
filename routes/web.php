<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\Siswa\ProfileController;

// 1. KUNCI PERBAIKAN: Definisikan lokasi file middleware di sini (agar tidak perlu lewat Kernel)
$roleMiddleware = \App\Http\Middleware\RoleManager::class;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// AUTHENTICATION
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'index');
    Route::post('/register', 'store');
});

// PROTECTED ROUTES (MUST LOGIN)
// 2. Tambahkan 'use ($roleMiddleware)' supaya variabel di atas bisa masuk ke dalam grup
Route::middleware(['auth'])->group(function () use ($roleMiddleware) {

    // --- ADMIN AREA ---
    // 3. Ganti 'role:admin' menjadi $roleMiddleware . ':admin'
    Route::prefix('admin')->name('admin.')->middleware($roleMiddleware . ':admin')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Master Data
        Route::resource('book', BookController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('student', StudentDashboardController::class);

        // Transactional
        Route::resource('transaction', TransactionController::class);
        Route::post('/transaction/{id}/approve', [TransactionController::class, 'approve'])->name('transaction.approve');
        Route::post('/transaction/{id}/reject', [TransactionController::class, 'reject'])->name('transaction.reject');
    });

    // --- SISWA AREA ---
    // 4. Ganti 'role:siswa' menjadi $roleMiddleware . ':siswa'
    Route::prefix('siswa')->name('siswa.')->middleware($roleMiddleware . ':siswa')->group(function () {

        Route::controller(StudentDashboardController::class)->group(function () {
            Route::get('/dashboard', 'dashboardSiswa')->name('dashboard');
            Route::get('/borrow', 'borrowing')->name('borrow');
            Route::get('/book/{id}', 'showBookDetail')->name('book.show');
            Route::get('/return', 'returning')->name('return');
        });

        Route::controller(TransactionController::class)->group(function () {
            Route::post('/borrow-action/{id}', 'pinjamBuku')->name('borrow.request');
            Route::post('/return-action/{id}', 'returnBook')->name('return.proses');
        });

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::post('/notif-dismiss', function () {
            \App\Models\Transaction::where('user_id', auth()->id())
                ->whereIn('status', ['borrowed', 'rejected'])
                ->where('updated_at', '>=', now()->subHours(24))
                ->update(['updated_at' => now()->subDays(2)]);

            return back();
        })->name('notif.dismiss');
    });
});
