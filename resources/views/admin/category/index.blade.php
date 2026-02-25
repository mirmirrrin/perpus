@extends('layouts.admin')

@section('content')
<div class="w-full">
    {{-- Header Section --}}
    <header class="mb-10 bg-white p-8 rounded-[2.5rem] shadow-sm border-b-4 border-[#c65c6a] flex flex-col lg:flex-row justify-between items-center gap-6 transition-all hover:shadow-md">
        {{-- Sisi Kiri: Judul --}}
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Data <span class="text-[#c65c6a]">Kategori</span></h2>
            <p class="text-sm text-gray-400 mt-1 font-bold uppercase tracking-[0.2em]">Pengelompokan Jenis Koleksi Perpustakaan</p>
        </div>

        {{-- Sisi Rapi: Gabungan Search & Tombol --}}
        <div class="flex flex-col md:flex-row items-center gap-4 w-full lg:w-auto">
            {{-- Form Search Bar --}}
            <div class="flex flex-col md:flex-row items-center gap-4 w-full lg:w-auto">

                {{-- Form Search dengan Tombol X --}}
                <form action="" method="GET" class="relative group w-full md:w-72">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari kategori..."
                        class="w-full pl-12 pr-12 py-3.5 rounded-2xl bg-[#fcf7f8] border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none text-sm font-bold transition-all shadow-inner">

                    {{-- Ikon Search (Kiri) --}}
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>

                    {{-- TOMBOL X (Hanya muncul jika ada input search) --}}
                    @if(request('search'))
                    <a href="{{ route('admin.category.index') }}"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-6 h-6 flex items-center justify-center bg-gray-200 hover:bg-[#c65c6a] text-gray-500 hover:text-white rounded-full transition-all duration-300 group/btn"
                        title="Bersihkan Pencarian">
                        <i class="fas fa-times text-[10px]"></i>
                    </a>
                    @endif
                </form>

                {{-- Tombol Tambah --}}
                <a href="{{ route('admin.category.create') }}" class="w-full md:w-auto bg-[#c65c6a] hover:bg-[#a34a56] text-white px-6 py-4 rounded-2xl font-bold shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3 whitespace-nowrap">
                    <i class="fas fa-tags text-lg"></i>
                    <span class="tracking-wide text-[10px] uppercase font-black">Tambah Kategori</span>
                </a>
            </div>
    </header>

    @if(request('search'))
    <div class="mb-6 px-4">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
            Hasil pencarian untuk: <span class="text-[#c65c6a]">"{{ request('search') }}"</span>
        </p>
    </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#fcf7f8]/50 border-b border-gray-100">
                <tr>
                    <th class="px-10 py-6 text-[10px] font-black uppercase text-gray-400 tracking-[0.2em] w-32">Urutan</th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase text-gray-400 tracking-[0.2em]">Nama Kategori Buku</th>
                    <th class="px-10 py-6 text-center text-[10px] font-black uppercase text-gray-400 tracking-[0.2em] w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $index => $cat)
                <tr class="bg-white hover:bg-gray-50 hover:shadow-xl hover:shadow-gray-100 hover:scale-[1.01] transition-all duration-300 group cursor-default">
                    <td class="px-10 py-6">
                        <span class="text-gray-300 font-black text-xl group-hover:text-[#c65c6a]/30 transition-colors">
                            {{ sprintf('%02d', $index + 1) }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#fdf2f3] rounded-xl flex items-center justify-center text-[#c65c6a] group-hover:bg-[#c65c6a] group-hover:text-white transition-all shadow-sm">
                                <i class="fas fa-bookmark text-xs"></i>
                            </div>
                            <span class="font-black text-gray-700 tracking-wide text-sm uppercase group-hover:text-[#c65c6a] transition-colors">
                                {{ $cat->name }}
                            </span>
                        </div>
                    </td>
                    <td class="px-10 py-6">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.category.edit', $cat->id) }}" class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-edit text-xs"></i>
                            </a>

                            <form action="{{ route('admin.category.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Semua buku dalam kategori ini mungkin akan terpengaruh.')">
                                @csrf @method('DELETE')
                                <button class="w-10 h-10 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-32 text-center">
                        <div class="flex flex-col items-center opacity-20">
                            <i class="fas fa-folder-open text-7xl mb-4 text-gray-300"></i>
                            <p class="text-gray-500 font-black uppercase tracking-widest text-xs">Belum ada kategori yang dibuat</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection