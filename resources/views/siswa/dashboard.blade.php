@extends('layouts.siswa')
@section('title', 'Dashboard')

@section('content')
<style>
    .glass {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid white;
    }

    .hover-lift {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(116, 53, 68, 0.2);
    }
</style>



<section class="maroon-gradient rounded-[3rem] p-12 text-white relative overflow-hidden mb-12 shadow-2xl shadow-[#743544]/30">
    <div class="relative z-10 max-w-2xl">
        <h2 class="text-4xl md:text-5xl font-extrabold mb-4 italic leading-tight">Halo, {{ Auth::user()->name }}! <br> Mau baca apa hari ini?</h2>
        <p class="text-red-50 text-lg font-medium opacity-90">Gunakan layanan mandiri untuk meminjam dan mengembalikan koleksi buku kami.</p>
    </div>
    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white opacity-10 rounded-full"></div>
</section>

{{-- Section Status di Dashboard --}}
<div class="mt-10 mb-10">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-black text-gray-800 uppercase tracking-tighter">Status Permintaan <span class="text-[#c65c6a]">Terbaru</span></h3>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @forelse($myRequests as $req)
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-50 flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#fcf7f8] rounded-2xl flex items-center justify-center">
                        <i class="fas fa-book text-[#c65c6a]"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm uppercase">{{ $req->book->name }}</h4>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Pinjam: {{ $req->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                @php
                $statusColors = [
                'pending' => 'bg-yellow-50 text-yellow-600',
                'borrowed' => 'bg-green-50 text-green-600',
                'rejected' => 'bg-red-50 text-red-600',
                'returned' => 'bg-blue-50 text-blue-600'
                ];
                $statusLabels = ['pending' => 'Menunggu', 'borrowed' => 'Diterima', 'rejected' => 'Ditolak', 'returned' => 'Selesai'];
                @endphp

                <span class="{{ $statusColors[$req->status] ?? 'bg-gray-50' }} px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest">
                    {{ $statusLabels[$req->status] ?? $req->status }}
                </span>
            </div>

            {{-- Muncul Otomatis Jika Ditolak --}}
            @if($req->status == 'rejected')
            <div class="p-4 bg-red-50 border-l-4 border-red-400 rounded-r-2xl">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-info-circle text-red-500 text-[10px]"></i>
                    <p class="text-[8px] text-gray-500 font-black uppercase tracking-widest">Catatan Admin:</p>
                </div>
                <p class="text-[11px] text-red-700 font-bold leading-relaxed italic">
                    "{{ $req->rejection_reason ?? 'Maaf, permintaanmu belum bisa kami setujui saat ini.' }}"
                </p>
            </div>
            @endif
        </div>
        @empty
        <div class="bg-white p-10 rounded-[2rem] text-center border-2 border-dashed border-gray-100">
            <p class="text-gray-400 font-bold text-[10px] uppercase tracking-widest">Belum ada aktivitas pinjam</p>
        </div>
        @endforelse
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center gap-5">
        <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center text-xl">
            <i class="fas fa-book-reader"></i>
        </div>
        <div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pinjaman Aktif</p>
            <p class="text-2xl font-black text-gray-800">{{ $activeBorrowCount ?? 0 }} Buku</p>
        </div>
    </div>
</div>

@endsection