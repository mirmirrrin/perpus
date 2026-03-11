@extends('layouts.admin')
@section('title', 'Tambah Buku Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <header class="mb-8 flex justify-between items-center bg-white p-8 rounded-[2rem] shadow-sm border-b-4 border-[#c65c6a]">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Input <span class="text-[#c65c6a]">Buku Baru</span></h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1 italic">Pastikan data koleksi sudah benar ya!</p>
        </div>
        <a href="{{ route('admin.book.index') }}" class="bg-gray-100 text-gray-500 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#c65c6a] hover:text-white transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </header>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        {{-- Form cuma satu di sini --}}
        <form action="{{ route('admin.book.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-6">
            @csrf

            <div class="space-y-2 mb-6">
                <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Sampul Buku</label>
                <input type="file" name="image" required class="w-full px-6 py-4 rounded-2xl bg-[#fcf7f8] border-2 border-dashed border-gray-200 focus:border-[#c65c6a] text-sm font-bold file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-[#c65c6a] file:text-white">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Judul Koleksi</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan judul buku..." required class="w-full px-6 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Penulis</label>
                    <input type="text" name="author" value="{{ old('author') }}" placeholder="Nama penulis..." class="w-full px-6 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Penerbit</label>
                    <input type="text" name="publisher" value="{{ old('publisher') }}" placeholder="Nama penerbit..." class="w-full px-6 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Kategori</label>
                    <select name="category_id" required class="w-full px-6 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 appearance-none cursor-pointer transition-all shadow-sm">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" placeholder="0" required min="0" class="w-full px-6 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-black text-gray-700 transition-all shadow-sm text-center md:text-left">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-xs font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Tahun Terbit</label>
                <input type="number" name="year"
                    value="{{ old('year', $book->year ?? '') }}"
                    placeholder="Contoh: 2024"
                    class="w-full px-5 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50 focus:bg-white focus:border-[#c65c6a] focus:ring-0 transition-all font-bold text-gray-700">
                @error('year') <p class="text-rose-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-xs font-black uppercase tracking-[0.2em] text-gray-500 mb-2">Sinopsis Buku</label>
                <textarea name="description" rows="5"
                    placeholder="Tuliskan ringkasan buku di sini..."
                    class="w-full px-5 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50 focus:bg-white focus:border-[#c65c6a] focus:ring-0 transition-all font-bold text-gray-700 leading-relaxed">{{ old('description', $book->description ?? '') }}</textarea>
                @error('description') <p class="text-rose-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-[#c65c6a] hover:bg-gray-800 text-white py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                <i class="fas fa-save"></i> Simpan Koleksi Buku
            </button>
        </form>
    </div>
</div>
@endsection