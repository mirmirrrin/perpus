<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request) 
    {
        $search = $request->search;

        $books = Book::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%");
            })
            ->get();

        return view('admin.book.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.book.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        // 1. Cari dulu apakah buku dengan judul, penulis, dan penerbit yang sama sudah ada
        $existingBook = Book::where('name', $request->name)
            ->where('author', $request->author)
            ->where('publisher', $request->publisher)
            ->first();

        if ($existingBook) {
            // 2. Kalau ada, update stoknya saja (stok lama + stok baru)
            $existingBook->update([
                'stock' => $existingBook->stock + $request->stock
            ]);

            return redirect()->route('admin.book.index')->with('success', 'Buku sudah ada, stok berhasil ditambahkan!');
        }

        // 3. Kalau tidak ada, baru buat data buku baru
        Book::create($request->all());

        return redirect()->route('admin.book.index')->with('success', 'Buku baru berhasil ditambah!');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.book.edit', compact('book'))->with('success', 'Buku berhasil diupdate!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return redirect()->route('admin.book.index')->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy($id)
    {
        Book::findOrFail($id)->delete();
        return redirect()->route('admin.book.index')->with('error', 'Buku berhasil dihapus dari sistem!');
    }
}
