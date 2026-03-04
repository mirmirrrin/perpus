<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $students = \App\Models\User::where('role', 'siswa')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('admin.student.index', compact('students'));
    }

    public function dashboardSiswa()
    {
        $userId = auth()->id();

        // Statistik kartu
        $activeBorrowCount = Transaction::where('user_id', $userId)->where('status', 'borrowed')->count();
        $pendingCount = Transaction::where('user_id', $userId)->where('status', 'pending')->count();

        // Data untuk list status di dashboard
        $myRequests = Transaction::with('book')
            ->where('user_id', $userId)
            ->latest()
            ->take(3) // 3 aja cukup buat di dashboard
            ->get();

        return view('siswa.dashboard', compact('activeBorrowCount', 'pendingCount', 'myRequests'));
    }

    public function borrowing(Request $request)
    {
        $search = $request->search;

        $books = Book::with('category')
            // Jangan di-filter stock > 0 di sini supaya buku tetap ketemu pas di-search
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->get();

        return view('siswa.pages.borrowing', compact('books'));
    }

    public function returning(Request $request)
    {
        $search = $request->query('search');

        $transactions = Transaction::with('book')
            ->where('user_id', auth()->id())
            ->where('status', 'borrowed') // Hanya yang statusnya sedang dipinjam
            ->when($search, function ($query) use ($search) {
                $query->whereHas('book', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();

        // Jika sedang mencari tapi tidak ada hasil, kirim pesan peringatan
        if ($search && $transactions->isEmpty()) {
            session()->flash('info', 'Buku "' . $search . '" tidak ditemukan di daftar pinjaman aktif Anda.');
        }

        return view('siswa.pages.returning', compact('transactions'));
    }
    public function create()
    {
        return view('admin.student.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'class' => 'required|string',
            'phone' => 'required',
        ]);

        \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->email,
            'password' => bcrypt('password123'),
            'role'     => 'siswa',
            'phone'    => $request->phone,
        ]);

        return redirect()->route('admin.student.index')->with('success', 'Siswa berhasil didaftarkan!');
    }

    // Ganti fungsi edit kamu jadi begini
    public function edit($id)
    {
        $student = \App\Models\User::where('role', 'siswa')->findOrFail($id);
        return view('admin.student.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required',
            'alamat' => 'nullable|string',
        ]);

        $student = \App\Models\User::where('role', 'siswa')->findOrFail($id);

        $student->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.student.index')->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        \App\Models\User::where('role', 'siswa')->findOrFail($id)->delete();
        return redirect()->route('admin.student.index')->with('error', 'Data siswa berhasil dihapus!');
    }
}
