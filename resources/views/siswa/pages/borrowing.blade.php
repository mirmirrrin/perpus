@extends('layouts.siswa')
@section('title', 'Koleksi Buku')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Header: Dibuat lebih dramatis --}}
    <header class="mb-12 flex flex-col md:flex-row justify-between items-center md:items-end gap-8">
        <div class="text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#fdf2f3] text-[#c65c6a] text-[10px] font-black uppercase tracking-[3px] mb-4 border border-[#c65c6a]/20 shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#c65c6a] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#c65c6a]"></span>
                </span>
                Library Discovery
            </div>
            <h2 class="text-5xl font-black text-gray-800 tracking-tighter uppercase italic leading-none">
                PINJAM <span class="text-[#c65c6a] relative">BUKU
                    <svg class="absolute -bottom-2 left-0 w-full h-2 text-[#c65c6a]/20" viewBox="0 0 100 10" preserveAspectRatio="none">
                        <path d="M0 5 Q 25 0 50 5 T 100 5" fill="none" stroke="currentColor" stroke-width="4" />
                    </svg>
                </span>
            </h2>
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-[0.3em] mt-5 flex items-center justify-center md:justify-start gap-3">
                <span class="w-12 h-[2px] bg-[#c65c6a]"></span>
                Temukan Referensi Terbaikmu
            </p>
        </div>

        {{-- Badge Stats --}}
        <div class="bg-white px-10 py-6 rounded-[2.5rem] shadow-[0_10px_30px_-15px_rgba(198,92,106,0.15)] border border-[#fcf7f8] text-center md:text-right transition-transform hover:scale-105">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Koleksi Digital</p>
            <p class="text-4xl font-black text-gray-800 tracking-tighter">{{ $books->count() }} <span class="text-[#c65c6a] text-sm italic uppercase tracking-normal">Buku Tersedia</span></p>
        </div>
    </header>

    {{-- Search Bar: Dibuat lebih lebar & "Pop" --}}
    <div class="mb-16 flex justify-center">
        <form action="{{ route('siswa.borrow') }}" method="GET" class="relative w-full max-w-2xl group">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari judul, penulis, atau penerbit..."
                class="w-full pl-16 pr-16 py-6 rounded-[2.5rem] bg-white border-2 border-transparent shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] focus:border-[#c65c6a] focus:ring-0 transition-all font-bold text-base text-gray-700 placeholder:text-gray-300">

            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#c65c6a] transition-colors">
                <i class="fas fa-search text-xl"></i>
            </div>

            @if(request('search'))
            <a href="{{ route('siswa.borrow') }}" class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 hover:text-rose-500 transition-colors">
                <i class="fas fa-times-circle text-xl"></i>
            </a>
            @endif
        </form>
    </div>

    {{-- Grid Buku --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">
        @forelse($books as $book)
        @php
        $userBorrowedThis = \App\Models\Transaction::where('user_id', auth()->id())
        ->where('book_id', $book->id)
        ->whereIn('status', ['pending', 'borrowed'])
        ->first();
        @endphp

        <div class="group relative flex flex-col">
            {{-- Card Image Utama --}}
            <div class="relative z-10 bg-white rounded-[3rem] p-4 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] border border-gray-50 transition-all duration-500 group-hover:-translate-y-4 group-hover:shadow-[0_40px_60px_-20px_rgba(198,92,106,0.15)]">

                {{-- Category Floating Tag --}}
                <div class="absolute top-6 right-6 z-20">
                    <span class="bg-white/90 backdrop-blur-md text-[#c65c6a] px-4 py-1.5 rounded-2xl text-[9px] font-black uppercase tracking-widest border border-gray-100 shadow-sm">
                        {{ $book->category->name ?? 'Umum' }}
                    </span>
                </div>

                {{-- Image Container --}}
                <div class="w-full h-64 bg-[#fcf7f8] rounded-[2.5rem] overflow-hidden relative shadow-inner">
                    @if($book->image)
                    <img src="{{ asset('storage/books/' . $book->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                    <div class="w-full h-full flex flex-col items-center justify-center gap-3">
                        <i class="fas fa-book-open text-[#c65c6a] text-5xl opacity-20 transition-all group-hover:scale-110 group-hover:opacity-100"></i>
                        <span class="text-[8px] font-black text-[#c65c6a]/40 uppercase tracking-[0.3em]">No Preview</span>
                    </div>
                    @endif

                    {{-- Overlay on Hover --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-[#c65c6a]/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-8">
                        <span class="text-white text-[10px] font-black uppercase tracking-widest">Lihat Detail</span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 space-y-5">
                    <div class="min-h-[3rem]">
                        <h3 class="font-black text-gray-800 uppercase text-lg leading-tight tracking-tighter italic line-clamp-2 group-hover:text-[#c65c6a] transition-colors">
                            {{ $book->name }}
                        </h3>
                    </div>

                    {{-- Metadata --}}
                    <div class="flex items-center justify-between border-t border-dashed border-gray-100 pt-5">
                        <div class="flex flex-col">
                            <span class="text-[8px] font-black text-gray-300 uppercase tracking-widest">Penulis</span>
                            <span class="text-[11px] font-extrabold text-gray-600 italic tracking-tight">{{ Str::limit($book->author, 15) }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[8px] font-black text-gray-300 uppercase tracking-widest block">Status</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-black {{ $book->stock > 0 ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500' }}">
                                {{ $book->stock }} Unit
                            </span>
                        </div>
                    </div>

                    {{-- Button Logic --}}
                    <div class="pt-2">
                        @if($userBorrowedThis)
                        <div class="w-full py-4 rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] text-center border-2 border-dashed flex items-center justify-center gap-2 {{ $userBorrowedThis->status == 'pending' ? 'border-amber-200 text-amber-500 bg-amber-50/30' : 'border-emerald-200 text-emerald-500 bg-emerald-50/30' }}">
                            <i class="fas {{ $userBorrowedThis->status == 'pending' ? 'fa-hourglass-half' : 'fa-check-double' }}"></i>
                            {{ $userBorrowedThis->status == 'pending' ? 'Pending' : 'Borrowed' }}
                        </div>
                        @elseif($book->stock > 0)
                        <form action="{{ route('siswa.borrow.request', $book->id) }}" method="POST" onsubmit="return confirm('Ajukan pinjaman untuk buku ini?')">
                            @csrf
                            <button type="submit" class="w-full bg-[#c65c6a] hover:bg-gray-800 text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] transition-all shadow-[0_10px_20px_-5px_rgba(198,92,106,0.3)] hover:shadow-xl active:scale-95 flex items-center justify-center gap-2">
                                <i class="fas fa-plus-circle text-xs"></i> Pinjam Sekarang
                            </button>
                        </form>
                        @else
                        <button disabled class="w-full bg-gray-50 text-gray-300 py-4 rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] cursor-not-allowed border border-gray-100 opacity-60">
                            Out of Stock
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Hiasan Shadow Belakang (Aksesoris Visual) --}}
            <div class="absolute -bottom-2 inset-x-8 h-10 bg-gray-200/20 blur-2xl -z-10 rounded-full group-hover:bg-[#c65c6a]/10 transition-colors"></div>
        </div>
        @empty
        <div class="col-span-full py-40 text-center">
            <div class="relative inline-block">
                <i class="fas fa-ghost text-8xl text-gray-100 animate-bounce"></i>
                <div class="absolute -bottom-4 left-0 w-full h-2 bg-gray-100 blur-lg rounded-full"></div>
            </div>
            <h4 class="mt-10 font-black text-gray-300 uppercase tracking-[0.5em] text-xs">Oopss! Buku tidak ditemukan</h4>
            <p class="text-gray-400 text-[10px] mt-4 font-bold italic">Coba gunakan kata kunci lain atau cek koleksi lainnya.</p>
            @if(request('search'))
            <a href="{{ route('siswa.book.show', $book->id) }}" class="absolute inset-0 bg-gradient-to-t from-[#c65c6a]/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-8">
                <span class="text-white text-[10px] font-black uppercase tracking-widest">Lihat Detail</span>
            </a> @endif
        </div>
        @endforelse
    </div>

    {{-- Footer Info --}}
    <div class="mt-20 border-t border-gray-100 pt-10 text-center">
        <p class="text-[9px] font-black text-gray-300 uppercase tracking-[0.3em]">Perpus Lyi &bull; Digital Library System &bull; 2026</p>
    </div>
</div>
@endsection