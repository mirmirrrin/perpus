@extends('layouts.siswa')
@section('title', 'Detail Buku - ' . $book->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    {{-- Back Button --}}
    <a href="{{ route('siswa.borrow') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-[#c65c6a] transition-colors mb-8 group">
        <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
        <span class="text-[10px] font-black uppercase tracking-[3px]">Kembali ke Koleksi</span>
    </a>

    <div class="flex flex-col lg:flex-row gap-16 items-start">
        {{-- Kiri: Sampul Buku --}}
        <div class="w-full lg:w-2/5 sticky top-10">
            <div class="relative group">
                {{-- Decorative Background --}}
                <div class="absolute -inset-4 bg-[#c65c6a]/5 rounded-[4rem] blur-2xl group-hover:bg-[#c65c6a]/10 transition-colors"></div>
                
                <div class="relative bg-white p-4 rounded-[3.5rem] shadow-2xl shadow-gray-200 border border-gray-50 overflow-hidden">
                    @if($book->image)
                        <img src="{{ asset('storage/books/' . $book->image) }}" 
                             alt="{{ $book->name }}" 
                             class="w-full aspect-[3/4] object-cover rounded-[2.5rem] shadow-inner">
                    @else
                        <div class="w-full aspect-[3/4] bg-gray-50 rounded-[2.5rem] flex flex-col items-center justify-center gap-4">
                            <i class="fas fa-book-open text-6xl text-gray-100"></i>
                            <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">No Cover Available</span>
                        </div>
                    @endif

                    {{-- Status Badge --}}
                    <div class="absolute top-8 right-8">
                        <span class="bg-white/90 backdrop-blur-md px-5 py-2 rounded-2xl shadow-lg border border-white text-[10px] font-black uppercase tracking-widest {{ $book->stock > 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                            {{ $book->stock > 0 ? 'Tersedia' : 'Kosong' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Detail Informasi --}}
        <div class="w-full lg:w-3/5 space-y-10">
            <div>
                <div class="inline-block px-4 py-1 rounded-full bg-[#fdf2f3] text-[#c65c6a] text-[10px] font-black uppercase tracking-[3px] mb-6 border border-[#c65c6a]/20">
                    {{ $book->category->name ?? 'Umum' }}
                </div>
                <h1 class="text-5xl lg:text-6xl font-black text-gray-800 uppercase italic tracking-tighter leading-[0.9] mb-4">
                    {{ $book->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-6 text-gray-400">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user-nib text-[#c65c6a]"></i>
                        <span class="text-xs font-bold uppercase tracking-widest">{{ $book->author ?? 'Anonim' }}</span>
                    </div>
                    <div class="w-1.5 h-1.5 rounded-full bg-gray-200"></div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-building text-[#c65c6a]"></i>
                        <span class="text-xs font-bold uppercase tracking-widest">{{ $book->publisher ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            {{-- Grid Info Tambahan --}}
            <div class="grid grid-cols-2 gap-8 py-8 border-y border-dashed border-gray-100">
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Tahun Terbit</p>
                    <p class="text-lg font-black text-gray-700 italic">{{ $book->year ?? '2024' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Stok Tersedia</p>
                    <p class="text-lg font-black text-gray-700 italic">{{ $book->stock }} <span class="text-xs uppercase text-gray-400">Eksemplar</span></p>
                </div>
            </div>

            {{-- Sinopsis --}}
            <div class="space-y-4">
                <h4 class="text-[11px] font-black text-gray-800 uppercase tracking-[0.3em] flex items-center gap-3">
                    Sinopsis Buku
                    <span class="flex-1 h-[1px] bg-gray-100"></span>
                </h4>
                <p class="text-gray-500 leading-relaxed italic font-medium">
                    {{ $book->synopsis ?? 'Belum ada deskripsi untuk buku ini. Silakan hubungi petugas perpustakaan untuk informasi lebih lanjut mengenai konten koleksi ini.' }}
                </p>
            </div>

            {{-- Action Button --}}
            <div class="pt-6">
                @php
                    $userBorrowedThis = \App\Models\Transaction::where('user_id', auth()->id())
                        ->where('book_id', $book->id)
                        ->whereIn('status', ['pending', 'borrowed'])
                        ->first();
                @endphp

                @if($userBorrowedThis)
                    <div class="w-full lg:w-max px-12 py-5 rounded-[2rem] font-black uppercase text-xs tracking-[0.2em] text-center border-2 border-dashed flex items-center justify-center gap-3 {{ $userBorrowedThis->status == 'pending' ? 'border-amber-200 text-amber-500 bg-amber-50/30' : 'border-emerald-200 text-emerald-500 bg-emerald-50/30' }}">
                        <i class="fas {{ $userBorrowedThis->status == 'pending' ? 'fa-hourglass-half' : 'fa-check-double' }} text-lg"></i>
                        {{ $userBorrowedThis->status == 'pending' ? 'Menunggu Konfirmasi Admin' : 'Sedang Kamu Pinjam' }}
                    </div>
                @elseif($book->stock > 0)
                    <form action="{{ route('siswa.borrow.request', $book->id) }}" method="POST" onsubmit="return confirm('Ajukan pinjaman sekarang?')">
                        @csrf
                        <button type="submit" class="w-full lg:w-max px-16 py-6 bg-[#c65c6a] hover:bg-gray-800 text-white rounded-[2rem] font-black uppercase text-xs tracking-[0.2em] transition-all shadow-2xl shadow-[#c65c6a]/30 hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                            <i class="fas fa-bookmark"></i>
                            Pinjam Buku Ini Sekarang
                        </button>
                    </form>
                @else
                    <div class="w-full lg:w-max px-12 py-5 rounded-[2rem] bg-gray-50 text-gray-300 font-black uppercase text-xs tracking-[0.2em] border border-gray-100 flex items-center gap-3 cursor-not-allowed">
                        <i class="fas fa-exclamation-triangle"></i>
                        Stok Koleksi Sedang Kosong
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection