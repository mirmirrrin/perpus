<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
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
        $books = Book::all();
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

        // Cari Siswa berdasarkan nama
        $user = User::where('name', $request->student_name)->first();
        if (!$user) return back()->with('error', 'Siswa tidak ditemukan!');

        // Cari Buku berdasarkan nama
        $book = Book::where('name', $request->book_name)->first();
        if (!$book) return back()->with('error', 'Buku tidak ditemukan!');

        if ($book->stock <= 0) return back()->with('error', 'Stok buku habis!');

        Transaction::create([
            'user_id'     => $user->id,
            'book_id'     => $book->id,
            'borrowed_at' => $request->borrowed_at,
            'returned_at' => $request->returned_at,
            'status'      => 'borrowed', // Manual oleh admin langsung 'borrowed'
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

        // Update data (User & Book tidak diubah karena dari form edit hanya tampilan)
        $transaction->update([
            'borrowed_at' => $request->borrowed_at,
            'returned_at' => $request->returned_at,
            'status'      => $request->status,
        ]);

        // LOGIKA STOK OTOMATIS
        // 1. Jika status berubah dari 'dipinjam' menjadi 'kembali'
        if ($oldStatus === 'borrowed' && $request->status === 'returned') {
            $transaction->book->increment('stock');
        }
        // 2. Jika status berubah dari 'kembali' ke 'dipinjam' lagi (salah input)
        elseif ($oldStatus === 'returned' && $request->status === 'borrowed') {
            $transaction->book->decrement('stock');
        }

        return redirect()->route('admin.transaction.index')->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Kembalikan stok jika data yang dihapus statusnya masih 'borrowed'
        if ($transaction->status === 'borrowed') {
            $transaction->book->increment('stock');
        }

        $transaction->delete();
        return redirect()->route('admin.transaction.index')->with('error', 'Data transaksi berhasil dihapus!');
    }

    // FUNGSI UNTUK SISWA REQUEST PINJAM
    public function pinjamBuku(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku sedang habis!');
        }

        Transaction::create([
            'user_id'     => auth()->id(),
            'book_id'     => $id,
            'borrowed_at' => now(),
            'returned_at' => now()->addDays(7), // Default tenggat 7 hari
            'status'      => 'pending',
        ]);

        return redirect()->route('siswa.borrow')->with('success', 'Permintaan terkirim! Menunggu konfirmasi admin.');
    }

    public function returnBook($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Cek dulu, kalau statusnya bukan 'borrowed', jangan diapa-apain
        if ($transaction->status !== 'borrowed') {
            return redirect()->back()->with('error', 'Transaksi tidak valid untuk pengembalian.');
        }

        // 1. Update status jadi 'returned'
        // 2. Isi tanggal pengembalian aslinya (optional kalau ada kolomnya)
        $transaction->update([
            'status' => 'returned',
            'actual_return_date' => now()
        ]);

        // 3. Tambah stok buku lagi karena sudah dibalikin
        $transaction->book->increment('stock');

        return redirect()->route('siswa.return')->with('success', 'Buku berhasil dikembalikan! Terima kasih.');
    }

    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status == 'pending') {
            $transaction->update(['status' => 'borrowed']);
            $transaction->book->decrement('stock'); // Stok berkurang saat di-ACC

            return redirect()->back()->with('success', 'Peminjaman disetujui!');
        }

        return redirect()->back()->with('error', 'Gagal menyetujui.');
    }

    public function reject(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status == 'pending') {
            $reason = $request->rejection_reason_manual ?? $request->rejection_reason_select;

            if (!$reason) {
                return redirect()->back()->with('error', 'Pilih atau isi alasan dulu, Mir!');
            }

            $transaction->update([
                'status' => 'rejected',
                'rejection_reason' => $reason
            ]);

            return redirect()->back()->with('success', 'Berhasil ditolak!');
        }

        return redirect()->back()->with('error', 'Gagal, status bukan pending.');
    }
}
