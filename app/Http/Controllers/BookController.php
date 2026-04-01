<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Tampilkan daftar koleksi buku
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $books = Book::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('admin.book.index', compact('books'));
    }

    /**
     * Form tambah buku baru
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.book.create', compact('categories'));
    }

    /**
     * Simpan buku baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'author'      => 'required|string',
            'publisher'   => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'year'        => 'nullable|numeric|digits:4',
        ]);

        // Cek apakah buku dengan judul, penulis, dan penerbit yang sama sudah ada
        $existingBook = Book::where('name', $request->name)
            ->where('author', $request->author)
            ->where('publisher', $request->publisher)
            ->first();

        if ($existingBook) {
            $existingBook->update([
                'stock' => $existingBook->stock + $request->stock
            ]);
            return redirect()->route('admin.book.index')->with('success', 'Buku sudah ada, stok berhasil ditambahkan!');
        }

        $data = $request->all();

        // Logika Upload Gambar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->storeAs('public/books', $nama_file);
            $data['image'] = $nama_file;
        }

        Book::create($data);

        return redirect()->route('admin.book.index')->with('success', 'Buku baru berhasil ditambah!');
    }

    /**
     * Form edit buku
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all(); // Tambahkan ini biar kategori bisa diganti saat edit
        return view('admin.book.edit', compact('book', 'categories'));
    }

    /**
     * Update data buku
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'year'        => 'nullable|numeric|digits:4',
        ]);

        $book = Book::findOrFail($id);
        $data = $request->all();

        // Logika Ganti Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($book->image) {
                Storage::delete('public/books/' . $book->image);
            }

            // Simpan gambar baru
            $file = $request->file('image');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->storeAs('public/books', $nama_file);
            $data['image'] = $nama_file;
        }

        $book->update($data);

        return redirect()->route('admin.book.index')->with('success', 'Buku berhasil diupdate!');
    }

    /**
     * Hapus buku dari sistem
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // 1. Cek apakah ada transaksi buku ini yang statusnya masih 'borrowed' (dipinjam)
        // Diasumsikan nama model transaksi kamu adalah 'Transaction'
        $isStillBorrowed = \App\Models\Transaction::where('book_id', $id)
            ->where('status', 'borrowed')
            ->exists();

        if ($isStillBorrowed) {
            // Jika masih ada yang pinjam, gagalkan penghapusan dan kirim pesan error
            return redirect()->route('admin.book.index')
                ->with('error', 'Gagal menghapus! Buku ini masih dalam status dipinjam oleh siswa.');
        }

        // 2. Jika aman (tidak ada yang pinjam), baru hapus gambar dan datanya
        if ($book->image) {
            Storage::delete('public/books/' . $book->image);
        }

        $book->delete();

        return redirect()->route('admin.book.index')
            ->with('error', 'Buku berhasil dihapus dari sistem!');
    }
}
