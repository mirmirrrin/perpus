@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
<div class="w-full">
    {{-- Header Section --}}
    <header class="mb-10 bg-white p-8 rounded-2xl shadow-sm flex justify-between items-center border-b-4 border-[#c65c6a]">
        <div>
            <h2 class="text-2xl font-black text-gray-800">Input <span class="text-[#c65c6a]">Buku Baru</span></h2>
            <p class="text-sm text-gray-400 mt-1 font-bold uppercase tracking-widest">Tambahkan koleksi ke perpustakaan</p>
        </div>
        <a href="{{ route('admin.book.index') }}" class="bg-gray-50 text-[#c65c6a] px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#c65c6a] hover:text-white transition-all flex items-center gap-2 shadow-sm">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </header>

    {{-- Form Section --}}
    <div class="max-w-5xl bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden transition-all hover:shadow-2xl hover:shadow-gray-200/50">
        <form action="{{ route('admin.book.store') }}" method="POST" class="p-10 space-y-8">
            @csrf

            {{-- Judul Buku --}}
            <div class="group">
                <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Judul Koleksi</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan judul buku secara lengkap" required
                    class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all placeholder:text-gray-300 shadow-sm">
            </div>

            {{-- Grid Penulis & Penerbit --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Penulis / Author</label>
                    <input type="text" name="author" value="{{ old('author') }}" placeholder="Masukkan Nama Penulis"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all placeholder:text-gray-300 shadow-sm">
                </div>
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Penerbit / Publisher</label>
                    <input type="text" name="publisher" value="{{ old('publisher') }}" placeholder="Masukkan Nama Penerbit"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all placeholder:text-gray-300 shadow-sm">
                </div>
            </div>

            {{-- Grid Kategori & Stok --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="relative">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Kategori Buku</label>
                    <div class="relative">
                        <select name="category_id" required
                            class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 appearance-none cursor-pointer transition-all shadow-sm">
                            <option value="" disabled selected>Pilih Kategori Utama</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-6 pointer-events-none text-[#c65c6a]">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Jumlah Stok Fisik</label>
                    <div class="relative">
                        <input type="number" name="stock" value="{{ old('stock') }}" placeholder="0" required min="0"
                            class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                        <div class="absolute inset-y-0 right-0 flex items-center px-6 pointer-events-none font-black text-[10px] text-gray-300 uppercase">Unit</div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-8">
                <button type="submit"
                    class="flex-[2] bg-[#c65c6a] hover:bg-[#a34a56] text-white py-5 rounded-2xl font-black uppercase tracking-[2px] shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-[0.98]">
                    <i class="fas fa-save mr-2"></i> Simpan Koleksi
                </button>
                <a href="{{ route('admin.book.index') }}"
                    class="flex-1 bg-gray-50 text-gray-400 py-5 rounded-2xl font-black uppercase tracking-[2px] text-center transition-all hover:bg-gray-100 active:scale-[0.98]">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection