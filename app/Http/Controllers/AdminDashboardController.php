<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Menghitung total semua buku
        $totalBooks = Book::count();

        // Menghitung total user dengan role siswa
        $totalStudents = User::where('role', 'siswa')->count();

        // Menghitung pinjaman yang statusnya masih dipinjam (borrowed)
        $activeLoans = Transaction::where('status', 'borrowed')->count();

        return view('admin.pages.dashboard', compact('totalBooks', 'totalStudents', 'activeLoans'));
    }
}
