@extends('layouts.siswa')
@section('title', 'Koleksi Buku')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
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
                PINJAM <span class="text-[#c65c6a]">BUKU</span>
            </h2>

            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-[0.3em] mt-5 flex items-center justify-center md:justify-start gap-3">
                <span class="w-12 h-[2px] bg-[#c65c6a]"></span>
                Temukan Referensi Terbaikmu
            </p>
        </div>

        <div class="bg-white px-10 py-6 rounded-[2.5rem] shadow-[0_10px_30px_-15px_rgba(198,92,106,0.15)] border border-[#fcf7f8] text-center md:text-right">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Koleksi Digital</p>
            <p class="text-4xl font-black text-gray-800 tracking-tighter">
                {{ $books->count() }}
                <span class="text-[#c65c6a] text-sm italic uppercase">Buku Tersedia</span>
            </p>
        </div>
    </header>

    {{-- Search --}}
    <div class="mb-16 flex justify-center">
        <form action="{{ route('siswa.borrow') }}" method="GET" class="relative w-full max-w-2xl group">

            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari judul, penulis, atau penerbit..."
                class="w-full pl-16 pr-16 py-6 rounded-[2.5rem] bg-white border-2 border-transparent shadow-lg focus:border-[#c65c6a] focus:ring-0 font-bold text-base text-gray-700 placeholder:text-gray-300">

            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#c65c6a]">
                <i class="fas fa-search text-xl"></i>
            </div>

            @if(request('search'))
            <a href="{{ route('siswa.borrow') }}" class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 hover:text-red-500">
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

            <div class="relative z-10 bg-white rounded-[3rem] p-4 shadow-lg border border-gray-50 transition-all duration-500 group-hover:-translate-y-4">

                {{-- Category --}}
                <div class="absolute top-6 right-6 z-20">
                    <span class="bg-white/90 backdrop-blur-md text-[#c65c6a] px-4 py-1.5 rounded-2xl text-[9px] font-black uppercase tracking-widest border border-gray-100 shadow-sm">
                        {{ $book->category->name ?? 'Umum' }}
                    </span>
                </div>

                {{-- Image --}}
                <div class="w-full h-64 bg-[#fcf7f8] rounded-[2.5rem] overflow-hidden relative">

                    @if($book->image)
                    <img src="{{ asset('storage/books/' . $book->image) }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-book-open text-[#c65c6a] text-5xl opacity-20"></i>
                    </div>
                    @endif

                    {{-- Overlay Detail --}}
                    <a href="{{ route('siswa.book.show', $book->id) }}"
                        class="absolute inset-0 bg-gradient-to-t from-[#c65c6a]/60 to-transparent opacity-0 group-hover:opacity-100 transition flex items-end justify-center pb-8">
                        <span class="text-white text-[10px] font-black uppercase tracking-widest">
                            Lihat Detail
                        </span>
                    </a>
                </div>

                {{-- Content --}}
                <div class="p-6 space-y-5">
                    <h3 class="font-black text-gray-800 uppercase text-lg leading-tight italic line-clamp-2">
                        {{ $book->name }}
                    </h3>

                    <div class="flex justify-between border-t border-dashed pt-4">
                        <div>
                            <span class="text-[8px] text-gray-300 uppercase">Penulis</span>
                            <p class="text-[11px] font-bold text-gray-600 italic">
                                {{ Str::limit($book->author, 15) }}
                            </p>
                        </div>

                        <div class="text-right">
                            <span class="text-[8px] text-gray-300 uppercase block">Stok</span>
                            <span class="text-xs font-bold {{ $book->stock > 0 ? 'text-green-500' : 'text-red-500' }}">
                                {{ $book->stock }} Unit
                            </span>
                        </div>
                    </div>

                    {{-- Button --}}
                    @if($userBorrowedThis)
                    <div class="w-full py-4 rounded-2xl font-black uppercase text-[10px] text-center border-2 border-dashed
                    {{ $userBorrowedThis->status == 'pending' ? 'border-amber-200 text-amber-500' : 'border-emerald-200 text-emerald-500' }}">

                        {{ $userBorrowedThis->status == 'pending' ? 'Pending' : 'Borrowed' }}
                    </div>
                    @elseif($book->stock > 0)
                    <form action="{{ route('siswa.borrow.request', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-[#c65c6a] hover:bg-gray-800 text-white py-4 rounded-2xl font-black uppercase text-[10px] transition">
                            Pinjam Sekarang
                        </button>
                    </form>
                    @else
                    <button disabled class="w-full bg-gray-100 text-gray-400 py-4 rounded-2xl font-black uppercase text-[10px]">
                        Out of Stock
                    </button>
                    @endif
                </div>
            </div>
        </div>

        @empty
        <div class="col-span-full py-40 text-center">
            <i class="fas fa-ghost text-8xl text-gray-200 mb-6"></i>
            <h4 class="font-black text-gray-300 uppercase tracking-widest text-xs">
                Buku tidak ditemukan
            </h4>
            <p class="text-gray-400 text-[10px] mt-3 italic">
                Coba kata kunci lain.
            </p>
            <a href="{{ route('siswa.borrow') }}"
                class="inline-block mt-6 bg-[#c65c6a] text-white px-6 py-3 rounded-xl text-xs font-black uppercase">
                Reset Pencarian
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection