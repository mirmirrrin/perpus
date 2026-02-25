@extends('layouts.siswa')

@section('content')
<div class="p-8">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Koleksi <span class="text-[#c65c6a]">Buku</span></h2>
        <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">Pilih buku yang ingin kamu pinjam hari ini</p>
    </div>

    {{-- Alert Sukses (Hijau) --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500"></i>
        <p class="text-green-700 font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Alert Hapus/Error (Merah) --}}
    @if(session('error'))
    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-xl flex items-center gap-3">
        <i class="fas fa-trash-alt text-red-500"></i>
        <p class="text-red-700 font-bold text-sm">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Form Search --}}
    {{-- Form Search --}}
    <form action="{{ route('siswa.borrow') }}" method="GET" class="relative group max-w-md mb-8">

        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku atau penulis"
            class="w-full pl-12 pr-12 py-3 rounded-xl bg-white border-2 border-gray-100 focus:border-[#c65c6a] focus:outline-none text-sm font-semibold transition-all shadow-sm">

        {{-- Ikon Search (Kiri) --}}
        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
            <i class="fas fa-search"></i>
        </div>

        {{-- Tombol X Bersihkan (Kanan) - Hanya muncul jika ada pencarian --}}
        @if(request('search'))
        <a href="{{ url()->current() }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#c65c6a] transition-colors">
            <i class="fas fa-times-circle"></i>
        </a>
        @endif
    </form>

    {{-- Pesan Hasil Cari --}}
    @if(request('search'))
    <div class="mb-6 px-4">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
            Hasil pencarian untuk: <span class="text-[#c65c6a]">"{{ request('search') }}"</span>
        </p>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

        @forelse($books as $book)
        <div class="bg-white rounded-[2.5rem] p-6 shadow-xl shadow-gray-100 border border-gray-50 flex flex-col items-center text-center group hover:scale-105 transition-all duration-300">
            <div class="w-20 h-20 bg-[#fcf7f8] rounded-2xl flex items-center justify-center mb-6 group-hover:bg-[#c65c6a] transition-colors">
                <i class="fas fa-book text-[#c65c6a] text-3xl group-hover:text-white"></i>
            </div>

            <span class="px-4 py-1 bg-[#fdf2f3] text-[#c65c6a] text-[9px] font-black uppercase rounded-full mb-4 border border-[#f5e1e4]">
                {{ $book->category->name ?? 'Umum' }}
            </span>

            <h3 class="font-black text-gray-800 uppercase text-lg leading-tight mb-4 h-12 flex items-center justify-center">
                {{ $book->name }}
            </h3>

            <div class="space-y-2 mb-8 w-full border-t border-dashed border-gray-100 pt-4">
                <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-gray-400">
                    <span><i class="fas fa-pen mr-1 text-[#c65c6a]"></i> Penulis</span>
                    <span class="text-gray-800">{{ $book->author }}</span>
                </div>
                <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-gray-400">
                    <span><i class="fas fa-box mr-1 text-[#c65c6a]"></i> Stok</span>
                    <span class="text-[#c65c6a] font-black">{{ $book->stock }} Unit</span>
                </div>
            </div>

            @if($book->stock > 0)
            <form action="{{ route('siswa.borrow.request', $book->id) }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full bg-[#c65c6a] hover:bg-[#a34a56] text-white py-4 rounded-2xl font-black uppercase text-xs tracking-widest shadow-lg shadow-red-100 transition-all active:scale-95">
                    Pinjam Sekarang
                </button>
            </form>
            @else
            <button disabled class="w-full bg-gray-100 text-gray-400 py-4 rounded-2xl font-black uppercase text-xs tracking-widest cursor-not-allowed">
                Stok Habis
            </button>
            @endif
        </div>
        @empty
        {{-- TAMPILAN JIKA DATA TIDAK DITEMUKAN --}}
        <div class="col-span-full py-24 text-center bg-white rounded-[3rem] shadow-sm border-2 border-dashed border-gray-100">
            <div class="w-24 h-24 bg-[#fcf7f8] rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-search text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Buku Tidak Ditemukan</h3>
            <p class="text-gray-400 font-bold text-xs uppercase tracking-widest mt-2">
                Maaf, buku dengan kata kunci <span class="text-[#c65c6a]">"{{ request('search') }}"</span> tidak tersedia.
            </p>
        </div>
        @endforelse
    </div>
</div>
@endsection