<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori dengan fitur pencarian
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $categories = Category::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })
            ->latest()
            ->get();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Form tambah kategori baru
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Simpan kategori baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        Category::create($request->all());

        return redirect()->route('admin.category.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Form edit kategori
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update data kategori
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Cek apakah ada buku yang pakai kategori ini sebelum dihapus
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih ada buku di dalamnya!');
        }

        $category->delete();
        return redirect()->route('admin.category.index')->with('error', 'Kategori berhasil dihapus!');
    }
}
