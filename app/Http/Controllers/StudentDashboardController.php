<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDE: Kelola Siswa (CRUD)
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = $request->search;

        $students = User::where('role', 'siswa')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.student.index', compact('students'));
    }

    public function create()
    {
        return view('admin.student.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'required',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->email, // Menggunakan email sebagai username
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
            'phone'    => $request->phone,
        ]);

        return redirect()->route('admin.student.index')->with('success', 'Siswa berhasil didaftarkan!');
    }

    public function edit($id)
    {
        $student = User::where('role', 'siswa')->findOrFail($id);
        return view('admin.student.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email,' . $id,
            'phone'  => 'required',
            'alamat' => 'nullable|string',
        ]);

        $student = User::where('role', 'siswa')->findOrFail($id);
        $student->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.student.index')->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        User::where('role', 'siswa')->findOrFail($id)->delete();
        return redirect()->route('admin.student.index')->with('error', 'Data siswa berhasil dihapus!');
    }

    /*
    |--------------------------------------------------------------------------
    | SISWA SIDE: Dashboard & Peminjaman
    |--------------------------------------------------------------------------
    */

    public function dashboardSiswa()
    {
        $userId = auth()->id();

        $activeBorrowCount = Transaction::where('user_id', $userId)->where('status', 'borrowed')->count();
        $pendingCount      = Transaction::where('user_id', $userId)->where('status', 'pending')->count();

        $myRequests = Transaction::with('book')
            ->where('user_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        return view('siswa.dashboard', compact('activeBorrowCount', 'pendingCount', 'myRequests'));
    }

    public function borrowing(Request $request)
    {
        $search = $request->search;

        $books = Book::with('category')
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
            ->where('status', 'borrowed')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('book', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();

        if ($search && $transactions->isEmpty()) {
            session()->flash('info', 'Buku "' . $search . '" tidak ditemukan di daftar pinjaman aktif Anda.');
        }

        return view('siswa.pages.returning', compact('transactions'));
    }
}
