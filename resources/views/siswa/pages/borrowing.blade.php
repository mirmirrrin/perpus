@extends('layouts.siswa')
@section('title', 'Koleksi Buku')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <header class="mb-10 flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            <div class="inline-block px-4 py-1 rounded-full bg-[#fdf2f3] text-[#c65c6a] text-[10px] font-black uppercase tracking-[3px] mb-3 border border-[#c65c6a]/20">Borrowing</div>
            <h2 class="text-4xl font-black text-gray-800 tracking-tighter uppercase italic text-white/0 bg-clip-text bg-gradient-to-r from-gray-800 to-gray-500">PINJAM <span class="text-[#c65c6a]">BUKU</span></h2>
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-[0.3em] mt-2 flex items-center gap-2">
                <span class="w-8 h-[2px] bg-[#c65c6a]"></span>
                Temukan referensi belajar terbaikmu
            </p>
        </div>
        <div class="bg-white px-8 py-5 rounded-[2rem] shadow-sm border border-gray-50 hidden md:block text-right">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Tersedia Saat Ini</p>
            <p class="text-2xl font-black text-[#c65c6a] tracking-tighter">{{ $books->count() }} <span class="text-gray-300 text-xs italic uppercase">Buku</span></p>
        </div>
    </header>

    {{-- Search Bar --}}
    <div class="mb-12">
        <form action="{{ route('siswa.borrow') }}" method="GET" class="relative max-w-xl">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, atau penerbit..."
                class="w-full pl-14 pr-14 py-5 rounded-[2.2rem] bg-white border-none shadow-sm focus:ring-2 focus:ring-[#c65c6a] transition-all font-bold text-sm text-gray-700">
            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-[#c65c6a]">
                <i class="fas fa-search text-lg"></i>
            </div>
            @if(request('search'))
            <a href="{{ route('siswa.borrow') }}" class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 hover:text-rose-500">
                <i class="fas fa-times-circle"></i>
            </a>
            @endif
        </form>
    </div>

    {{-- Grid Buku --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
        @forelse($books as $book)
        <div class="bg-white rounded-[3rem] p-7 shadow-sm border border-gray-50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group relative">

            {{-- Category Tag --}}
            <div class="absolute top-8 right-8 z-10">
                <span class="bg-white/80 backdrop-blur-md text-[#c65c6a] px-3 py-1 rounded-xl text-[8px] font-black uppercase tracking-widest border border-gray-100 shadow-sm">
                    {{ $book->category->name ?? 'Umum' }}
                </span>
            </div>

            {{-- Icon/Image --}}
            <div class="w-full h-44 bg-[#fcf7f8] rounded-[2.5rem] mb-8 flex items-center justify-center shadow-inner group-hover:bg-[#c65c6a] transition-colors duration-500 overflow-hidden">
                @if($book->image)
                <img src="{{ asset('storage/' . $book->image) }}" class="w-full h-full object-cover">
                @else
                <i class="fas fa-book-open text-[#c65c6a] text-5xl group-hover:text-white transition-all duration-500"></i>
                @endif
            </div>

            {{-- Content --}}
            <div class="space-y-4">
                <h3 class="font-black text-gray-800 uppercase text-md leading-tight tracking-tighter italic h-12 line-clamp-2">
                    {{ $book->name }}
                </h3>

                {{-- Detail Info --}}
                <div class="grid grid-cols-1 gap-2 border-y border-dashed border-gray-100 py-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Penulis</span>
                        <span class="text-[10px] font-bold text-gray-700 italic">{{ Str::limit($book->author, 18) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Penerbit</span>
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-tight">{{ Str::limit($book->publisher ?? 'N/A', 15) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Stok Buku</span>
                        <span class="text-[10px] font-black {{ $book->stock > 0 ? 'text-emerald-500' : 'text-rose-500' }}">{{ $book->stock }} Unit</span>
                    </div>
                </div>

                @if($book->stock > 0)
                <form action="{{ route('siswa.borrow.request', $book->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-[#c65c6a] hover:bg-[#3a1620] text-white py-4 rounded-2xl font-black uppercase text-[9px] tracking-[0.2em] transition-all shadow-lg active:scale-95">
                        Ajukan Pinjaman
                    </button>
                </form>
                @else
                <button disabled class="w-full bg-gray-50 text-gray-300 py-4 rounded-2xl font-black uppercase text-[9px] tracking-[0.2em] cursor-not-allowed border border-gray-100">
                    Stok Kosong
                </button>
                @endif
            </div>
        </div>
        @empty
        {{-- Tampilan Kosong --}}
        <div class="col-span-full py-20 text-center">
            <p class="text-gray-300 font-black uppercase tracking-[0.5em] text-sm italic">Data Tidak Tersedia</p>
        </div>
        @endforelse
    </div>
</div>
@endsection