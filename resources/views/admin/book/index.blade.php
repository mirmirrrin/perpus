@extends('layouts.admin')

@section('title', 'Daftar Koleksi Buku')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header Section --}}
    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm mb-8 border-b-8 border-[#c65c6a] flex flex-col lg:flex-row justify-between items-center gap-8 transition-all hover:shadow-md">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-10 h-[3px] bg-[#c65c6a] rounded-full"></span>
                <p class="text-[10px] font-black text-[#c65c6a] uppercase tracking-[0.3em]">Database Perpustakaan</p>
            </div>
            <h2 class="text-4xl font-black text-gray-800 tracking-tighter uppercase italic">Kelola <span class="text-[#c65c6a]">Buku</span></h2>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-5 w-full lg:w-auto">
            {{-- Form Search --}}
            <form action="{{ route('admin.book.index') }}" method="GET" class="relative group w-full md:w-72">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data buku..."
                    class="w-full pl-12 pr-10 py-4 rounded-2xl bg-[#fcf7f8] border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none text-sm font-bold transition-all shadow-inner">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#c65c6a]">
                    <i class="fas fa-search"></i>
                </div>
            </form>

            <a href="{{ route('admin.book.create') }}" class="w-full md:w-auto bg-[#c65c6a] hover:bg-gray-800 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                <i class="fas fa-plus-circle"></i>
                <span class="tracking-widest text-[11px] uppercase">Tambah Buku</span>
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[3rem] shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcf7f8]/50 border-b border-gray-50">
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Judul Buku</th>
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Kategori</th>
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Penulis</th>
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Penerbit</th>
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Stok</th>
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($books as $book)
                    <tr class="bg-white hover:bg-gray-50 hover:shadow-xl hover:shadow-gray-100 hover:scale-[1.01] transition-all duration-300 group cursor-default">
                        {{-- Judul --}}
                        <td class="px-8 py-6">
                            <span class="text-sm font-black text-gray-800 font black tracking-tight group-hover:text-[#c65c6a] transition-colors">
                                {{ $book->name }}
                            </span>
                        </td>

                        {{-- Kategori --}}
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 bg-[#fdf2f3] text-[#c65c6a] text-[9px] font-black uppercase rounded-lg border border-[#f5e1e4]">
                                {{ $book->category->name ?? 'Umum' }}
                            </span>
                        </td>

                        {{-- Penulis --}}
                        <td class="px-8 py-6">
                            <p class="text-xs text-gray-600 font-bold italic tracking-tight italic">{{ $book->author ?? '-' }}</p>
                        </td>

                        {{-- Penerbit --}}
                        <td class="px-8 py-6">
                            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">{{ $book->publisher ?? '-' }}</p>
                        </td>

                        {{-- Stok --}}
                        <td class="px-8 py-6 text-center">
                            <div class="inline-block px-3 py-1 bg-gray-50 rounded-md border border-gray-100">
                                <span class="font-black text-sm text-gray-800">{{ $book->stock }}</span>
                                <span class="text-[8px] text-gray-300 uppercase ml-1">Unit</span>
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-8 py-6">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.book.edit', $book->id) }}"
                                    class="w-9 h-9 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.book.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf @method('DELETE')
                                    <button class="w-9 h-9 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-24 text-center">
                            <div class="opacity-20 flex flex-col items-center">
                                <i class="fas fa-book-open text-6xl mb-4 text-gray-300"></i>
                                <p class="text-[11px] font-black uppercase tracking-[0.4em]">Data Buku Tidak Ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection