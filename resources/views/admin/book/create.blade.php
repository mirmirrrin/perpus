@extends('layouts.admin')

@section('title', 'Tambah Buku Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <header class="mb-8 flex justify-between items-center bg-white p-8 rounded-[2rem] shadow-sm border-b-4 border-[#c65c6a]">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Input <span class="text-[#c65c6a]">Buku Baru</span></h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1 italic">Pastikan data koleksi sudah benar ya, Mir!</p>
        </div>
        <a href="{{ route('admin.book.index') }}" class="bg-gray-100 text-gray-500 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#c65c6a] hover:text-white transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </header>

    {{-- Form Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.book.store') }}" method="POST" class="p-10 space-y-6">
            @csrf

            {{-- Judul Buku --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Judul Lengkap Koleksi</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan judul buku..." required
                    class="w-full px-6 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
            </div>

            {{-- Baris: Penulis & Penerbit --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Penulis / Author</label>
                    <input type="text" name="author" value="{{ old('author') }}" placeholder="Nama penulis..."
                        class="w-full px-6 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Penerbit / Publisher</label>
                    <input type="text" name="publisher" value="{{ old('publisher') }}" placeholder="Nama penerbit..."
                        class="w-full px-6 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>
            </div>

            {{-- Baris: Kategori & Stok --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Kategori Buku</label>
                    <div class="relative">
                        <select name="category_id" required
                            class="w-full px-6 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 appearance-none cursor-pointer transition-all shadow-sm">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-[#c65c6a] pointer-events-none text-xs"></i>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Jumlah Stok</label>
                    <div class="relative">
                        <input type="number" name="stock" value="{{ old('stock') }}" placeholder="0" required min="0"
                            class="w-full px-6 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-black text-gray-700 transition-all shadow-sm text-center md:text-left">
                        <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[9px] font-black text-gray-300 uppercase">Unit</span>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="pt-6">
                <button type="submit" class="w-full bg-[#c65c6a] hover:bg-gray-800 text-white py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                    <i class="fas fa-save"></i>
                    <span>Simpan Koleksi Buku</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection