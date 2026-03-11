@extends('layouts.siswa')
@section('title', 'Detail Buku')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <a href="{{ route('siswa.borrow') }}" class="inline-flex items-center text-gray-400 hover:text-[#c65c6a] font-black text-[10px] uppercase tracking-[0.3em] mb-10 transition-colors">
        <i class="fas fa-arrow-left mr-3"></i> Kembali ke Katalog
    </a>

    <div class="bg-white rounded-[3.5rem] shadow-[0_40px_80px_-20px_rgba(0,0,0,0.08)] border border-gray-50 overflow-hidden">
        <div class="flex flex-col md:flex-row">
            {{-- Bagian Kiri: Gambar --}}
            <div class="md:w-2/5 p-10 bg-[#fcf7f8]">
                <div class="sticky top-10">
                    <div class="relative group">
                        <div class="absolute -inset-4 bg-[#c65c6a]/10 rounded-[3rem] blur-2xl opacity-0 group-hover:opacity-100 transition duration-700"></div>
                        @if($book->image)
                        <img src="{{ asset('storage/books/' . $book->image) }}" class="relative w-full aspect-[3/4] object-cover rounded-[2.5rem] shadow-2xl transition-transform duration-700 group-hover:scale-[1.02]">
                        @else
                        <div class="relative w-full aspect-[3/4] bg-white rounded-[2.5rem] flex items-center justify-center border-2 border-dashed border-gray-200">
                            <i class="fas fa-book text-gray-200 text-6xl"></i>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Info --}}
            <div class="md:w-3/5 p-12 md:p-16">
                <div class="inline-block px-5 py-2 rounded-2xl bg-[#fdf2f3] text-[#c65c6a] text-[10px] font-black uppercase tracking-widest mb-6 border border-[#c65c6a]/10">
                    {{ $book->category->name ?? 'Umum' }}
                </div>

                <h1 class="text-4xl md:text-5xl font-black text-gray-800 uppercase italic tracking-tighter leading-none mb-4">
                    {{ $book->name }}
                </h1>

                <div class="flex flex-wrap gap-8 mb-10 border-b border-dashed border-gray-100 pb-10 mt-8">
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1">Penulis</p>
                        <p class="text-gray-700 font-bold italic">{{ $book->author }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1">Penerbit</p>
                        <p class="text-gray-700 font-bold italic">{{ $book->publisher }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1">Tahun</p>
                        <p class="text-gray-700 font-bold italic">{{ $book->year ?? '-' }}</p>
                    </div>
                </div>

                <div class="mb-12">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4 flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-[#c65c6a]"></span> Sinopsis Buku
                    </h4>
                    <p class="text-gray-500 leading-relaxed font-medium italic">
                        {{ $book->description ?? 'Belum ada sinopsis untuk buku ini.' }}
                    </p>
                </div>

                {{-- Action Button --}}
                <div class="flex items-center gap-6">
                    @if($userBorrowedThis)
                    <div class="flex-1 py-5 rounded-3xl font-black uppercase text-[12px] tracking-[0.2em] text-center border-2 border-dashed flex items-center justify-center gap-3 {{ $userBorrowedThis->status == 'pending' ? 'border-amber-200 text-amber-500 bg-amber-50/30' : 'border-emerald-200 text-emerald-500 bg-emerald-50/30' }}">
                        <i class="fas {{ $userBorrowedThis->status == 'pending' ? 'fa-hourglass-half animate-pulse' : 'fa-check-double' }}"></i>
                        Status: {{ ucfirst($userBorrowedThis->status) }}
                    </div>
                    @elseif($book->stock > 0)
                    <form action="{{ route('siswa.borrow.request', $book->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-[#c65c6a] hover:bg-gray-800 text-white py-5 rounded-3xl font-black uppercase text-[12px] tracking-[0.2em] transition-all shadow-xl shadow-[#c65c6a]/20 active:scale-95 flex items-center justify-center gap-3">
                            <i class="fas fa-plus-circle"></i> Ajukan Pinjaman
                        </button>
                    </form>
                    @else
                    <button disabled class="flex-1 bg-gray-50 text-gray-300 py-5 rounded-3xl font-black uppercase text-[12px] tracking-[0.2em] cursor-not-allowed border border-gray-100">
                        Stok Habis
                    </button>
                    @endif

                    <div class="text-right">
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1">Tersedia</p>
                        <p class="text-2xl font-black text-gray-800 tracking-tighter">{{ $book->stock }} <span class="text-[10px] text-[#c65c6a]">Unit</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection