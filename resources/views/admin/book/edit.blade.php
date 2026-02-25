@extends('layouts.admin')

@section('content')
<div class="w-full">
    {{-- Header Section --}}
    <header class="mb-10 bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#c65c6a] flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-800">Edit <span class="text-[#c65c6a]">Informasi Buku</span></h2>
            <p class="text-sm text-gray-400 mt-1 font-bold uppercase tracking-widest">Perbarui detail koleksi perpustakaan</p>
        </div>
        <a href="{{ route('admin.book.index') }}" class="bg-gray-50 text-[#c65c6a] px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#c65c6a] hover:text-white transition-all flex items-center gap-2">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </header>

    <div class="max-w-4xl mx-auto md:mx-0">
        <form action="{{ route('admin.book.update', $book->id) }}" method="POST" class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
            @csrf
            @method('PUT')

            @if ($errors->any())
            <div class="mb-8 p-5 bg-red-50 rounded-2xl border-l-8 border-red-500 text-red-700 animate-head-shake">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                    <div>
                        <p class="font-black text-sm uppercase tracking-tight">Terjadi Kesalahan Input</p>
                        <p class="text-xs font-bold opacity-80">Mohon periksa kembali data yang kamu masukkan ya Mir!</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="space-y-6">
                {{-- Input Judul --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest ml-1">Judul Buku</label>
                    <input type="text" name="name" value="{{ $book->name }}"
                        class="w-full px-6 py-4 bg-[#fcf7f8] rounded-xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>

                {{-- Grid Penulis & Penerbit --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest ml-1">Penulis</label>
                        <input type="text" name="author" value="{{ $book->author }}"
                            class="w-full px-6 py-4 bg-[#fcf7f8] rounded-xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest ml-1">Penerbit</label>
                        <input type="text" name="publisher" value="{{ $book->publisher }}"
                            class="w-full px-6 py-4 bg-[#fcf7f8] rounded-xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest ml-1">Kategori Buku</label>
                    <div class="relative">
                        <select name="category_id" class="w-full px-6 py-4 bg-[#fcf7f8] rounded-xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 appearance-none cursor-pointer transition-all shadow-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-6 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest ml-1">Stok Tersedia</label>
                    <div class="relative">
                        <input type="number" name="stock" value="{{ $book->stock }}"
                            class="w-full px-6 py-4 bg-[#fcf7f8] rounded-xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                        <div class="absolute inset-y-0 right-0 flex items-center px-6 pointer-events-none font-black text-[10px] text-gray-300 uppercase">Unit</div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#c65c6a] text-white py-5 rounded-2xl font-black uppercase tracking-[2px] shadow-xl shadow-[#c65c6a]/20 mt-8 active:scale-[0.98] transition-all">
                    <i class="fas fa-sync-alt mr-2"></i> Perbarui Data Koleksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection