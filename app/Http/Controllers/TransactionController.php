<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDE: Monitoring & CRUD
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = $request->search;

        $transactions = Transaction::with(['book.category', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('book', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('admin.transaction.index', compact('transactions'));
    }

    public function create()
    {
        $books = Book::where('stock', '>', 0)->get(); // Hanya buku yang ada stoknya
        $students = User::where('role', 'siswa')->get();
        return view('admin.transaction.create', compact('books', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string',
            'book_name'    => 'required|string',
            'borrowed_at'  => 'required|date',
            'returned_at'  => 'required|date|after_or_equal:borrowed_at',
        ]);

        $user = User::where('name', $request->student_name)->first();
        $book = Book::where('name', $request->book_name)->first();

        if (!$user) return back()->with('error', 'Siswa tidak ditemukan!');
        if (!$book) return back()->with('error', 'Buku tidak ditemukan!');
        if ($book->stock <= 0) return back()->with('error', 'Stok buku habis!');

        Transaction::create([
            'user_id'     => $user->id,
            'book_id'     => $book->id,
            'borrowed_at' => $request->borrowed_at,
            'returned_at' => $request->returned_at,
            'status'      => 'borrowed',
        ]);

        $book->decrement('stock');
        return redirect()->route('admin.transaction.index')->with('success', 'Transaksi Berhasil!');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('admin.transaction.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $request->validate([
            'borrowed_at' => 'required|date',
            'returned_at' => 'required|date',
            'status'      => 'required|in:pending,borrowed,returned,rejected',
        ]);

        $oldStatus = $transaction->status;

        $transaction->update([
            'borrowed_at' => $request->borrowed_at,
            'returned_at' => $request->returned_at,
            'status'      => $request->status,
        ]);

        // Logika Stok Otomatis
        if ($oldStatus === 'borrowed' && $request->status === 'returned') {
            $transaction->book->increment('stock');
        } elseif ($oldStatus === 'returned' && $request->status === 'borrowed') {
            $transaction->book->decrement('stock');
        }

        return redirect()->route('admin.transaction.index')->with('success', 'Transaksi diupdate!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        if ($transaction->status === 'borrowed') {
            $transaction->book->increment('stock');
        }
        $transaction->delete();
        return redirect()->route('admin.transaction.index')->with('error', 'Transaksi dihapus!');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDE: Approval (Persetujuan Pinjam)
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'pending') return back()->with('error', 'Gagal menyetujui.');
        if ($transaction->book->stock <= 0) return back()->with('error', 'Stok buku habis!');

        $transaction->update(['status' => 'borrowed']);
        $transaction->book->decrement('stock');

        return redirect()->back()->with('success', 'Peminjaman disetujui!');
    }

    public function reject(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        if ($transaction->status !== 'pending') return back()->with('error', 'Bukan status pending.');

        $reason = $request->rejection_reason_manual ?: $request->rejection_reason_select;
        if (!$reason) return redirect()->back()->with('error', 'Isi alasannya dulu!');

        $transaction->update([
            'status' => 'rejected',
            'rejection_reason' => $reason
        ]);

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    /*
    |--------------------------------------------------------------------------
    | SISWA SIDE: Pinjam & Kembalikan
    |--------------------------------------------------------------------------
    */

    public function pinjamBuku($id)
    {
        $book = Book::findOrFail($id);
        $userId = auth()->id();

        $alreadyBorrowed = Transaction::where('user_id', $userId)
            ->where('book_id', $id)
            ->whereIn('status', ['pending', 'borrowed'])
            ->exists();

        if ($alreadyBorrowed) return back()->with('error', 'Kamu sudah pinjam/request buku ini!');
        if ($book->stock <= 0) return back()->with('error', 'Stok habis!');

        Transaction::create([
            'user_id'     => $userId,
            'book_id'     => $id,
            'borrowed_at' => now(),
            'returned_at' => now()->addDays(7),
            'status'      => 'pending',
        ]);

        return redirect()->back()->with('success', 'Permintaan terkirim!');
    }

    public function returnBook($id)
    {
        $transaction = Transaction::findOrFail($id);
        if ($transaction->status !== 'borrowed') return back()->with('error', 'Status tidak valid.');

        $transaction->update([
            'status' => 'returned',
            'actual_return_date' => now()
        ]);
        $transaction->book->increment('stock');

        return redirect()->back()->with('success', 'Buku dikembalikan!');
    }
}
