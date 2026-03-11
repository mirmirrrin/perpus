@extends('layouts.siswa')
@section('title', 'Pinjaman Saya')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header Section --}}
    <header class="mb-10 flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            <div class="inline-block px-4 py-1 rounded-full bg-[#fdf2f3] text-[#c65c6a] text-[10px] font-black uppercase tracking-[3px] mb-3 border border-[#c65c6a]/20">My Borrowing</div>
            <h2 class="text-4xl font-black text-gray-800 tracking-tighter uppercase italic">PINJAMAN <span class="text-[#c65c6a]">AKTIF</span></h2>
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-[0.3em] mt-2 flex items-center gap-2">
                <span class="w-8 h-[2px] bg-[#c65c6a]"></span>
                Daftar buku yang sedang kamu bawa
            </p>
        </div>
        <div class="bg-white px-8 py-5 rounded-[2rem] shadow-sm border border-gray-50 hidden md:block text-right">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Buku di Tangan</p>
            <p class="text-2xl font-black text-[#c65c6a] tracking-tighter">{{ $transactions->count() }} <span class="text-gray-300 text-xs italic uppercase">Buku</span></p>
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

    {{-- Main Table Card --}}
    <div class="bg-white rounded-[3rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcf7f8]/50 border-b border-gray-50">
                        <th class="px-10 py-8 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Detail Literasi</th>
                        <th class="px-10 py-8 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Penulis</th>
                        <th class="px-10 py-8 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Penerbit</th>
                        <th class="px-10 py-8 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tenggat</th>
                        <th class="px-10 py-8 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $trx)
                    @php
                    $tenggat = \Carbon\Carbon::parse($trx->returned_at);
                    $isTerlambat = now()->gt($tenggat);
                    @endphp
                    <tr class="bg-white hover:bg-gray-50/50 transition-all duration-300 group">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-[#fdf2f3] text-[#c65c6a] rounded-[1.2rem] flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-500">
                                    <i class="fas fa-book-reader text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-gray-800 font-black text-sm uppercase tracking-tight italic">{{ $trx->book->name }}</span>
                                    <span class="text-[9px] text-[#c65c6a] font-bold tracking-[0.2em] uppercase">ID: #BUK-{{ $trx->book_id }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-7">
                            <div class="flex items-center gap-2 text-gray-600">
                                <i class="fas fa-pen-nib text-[10px] text-[#c65c6a]"></i>
                                <span class="text-[11px] font-bold uppercase tracking-tighter">{{ $trx->book->author }}</span>
                            </div>
                        </td>

                        <td class="px-8 py-7 text-gray-400">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-building text-[10px]"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ $trx->book->publisher ?? 'N/A' }}</span>
                            </div>
                        </td>

                        <td class="px-10 py-8">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Pinjam: {{ \Carbon\Carbon::parse($trx->borrowed_at)->format('d/m/y') }}</span>
                                </div>
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl w-fit {{ $isTerlambat ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-blue-50 text-blue-600 border border-blue-100' }}">
                                    <i class="fas fa-clock text-[10px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-tighter">
                                        Tenggat: {{ $tenggat->format('d M Y') }}
                                    </span>
                                </div>
                                @if($isTerlambat)
                                <span class="text-[8px] font-black text-rose-400 uppercase animate-pulse">Terlambat!</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-8 py-7 text-center">
                            <form action="{{ route('siswa.return.proses', $trx->id) }}" method="POST" onsubmit="return confirm('Kembalikan buku ini sekarang?')">
                                @csrf
                                <button type="submit" class="bg-[#3a1620] hover:bg-[#c65c6a] text-white px-7 py-3 rounded-[1.2rem] text-[9px] font-black uppercase tracking-[0.2em] transition-all shadow-lg active:scale-95 group-hover:shadow-[#c65c6a]/20">
                                    Kembalikan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        {{-- PERBAIKAN: Colspan diubah menjadi 5 agar sesuai jumlah kolom --}}
                        <td colspan="5" class="p-32 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <i class="fas fa-search-minus text-8xl mb-6 text-gray-400"></i>
                                <p class="text-gray-500 font-black uppercase tracking-[0.4em] text-[10px]">
                                    @if(request('search'))
                                    Buku "{{ request('search') }}" tidak ditemukan
                                    @else
                                    Belum ada buku yang dipinjam
                                    @endif
                                </p>
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