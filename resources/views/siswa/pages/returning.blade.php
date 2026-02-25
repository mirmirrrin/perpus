@extends('layouts.siswa')
@section('title', 'Pinjaman Saya')

@section('content')
<header class="mb-10">
    <h2 class="text-4xl font-black text-gray-800 tracking-tighter uppercase">Daftar <span class="text-[#c65c6a]">Pinjaman Aktif</span></h2>
    <p class="text-gray-400 text-[10px] font-black uppercase tracking-[3px] mt-2">Segera kembalikan jika sudah selesai membaca ya!</p>
</header>

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

<div class="bg-white rounded-[3rem] shadow-2xl shadow-[#c65c6a]/10 border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-[#fdf6f7]">
            <tr>
                <th class="p-8 text-left text-[11px] font-black text-[#c65c6a] uppercase tracking-[3px]">Judul Koleksi</th>
                <th class="p-8 text-left text-[11px] font-black text-[#c65c6a] uppercase tracking-[3px]">Tanggal Pinjam</th>
                {{-- TAMBAHAN HEADER TENGGAT --}}
                <th class="p-8 text-left text-[11px] font-black text-[#c65c6a] uppercase tracking-[3px]">Tenggat Waktu</th>
                <th class="p-8 text-center text-[11px] font-black text-[#c65c6a] uppercase tracking-[3px]">Tindakan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 font-bold">
            @forelse($transactions as $trx)
            @php
            $tenggat = \Carbon\Carbon::parse($trx->returned_at);
            $isTerlambat = now()->gt($tenggat);
            @endphp
            <tr class="hover:bg-[#fdf6f7]/30 transition-all">
                <td class="p-8">
                    <span class="block text-gray-800 uppercase tracking-tight">{{ $trx->book->name }}</span>
                    <span class="text-[10px] text-gray-400 uppercase italic">ID Buku: #{{ $trx->book_id }}</span>
                </td>
                <td class="p-8 text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($trx->borrowed_at)->format('d F Y') }}
                </td>

                {{-- ISI KOLOM TENGGAT --}}
                <td class="p-8">
                    <div class="flex flex-col">
                        <span class="text-sm {{ $isTerlambat ? 'text-red-500 animate-pulse' : 'text-gray-600' }}">
                            {{ $tenggat->format('d F Y') }}
                        </span>
                        @if($isTerlambat)
                        <span class="text-[9px] font-black text-red-600 uppercase italic">Terlambat!</span>
                        @endif
                    </div>
                </td>

                <td class="p-8 text-center">
                    <form action="{{ route('siswa.return.proses', $trx->id) }}" method="POST">
                        @csrf
                        <button class="bg-white border-2 border-[#c65c6a] text-[#c65c6a] px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#c65c6a] hover:text-white transition-all shadow-sm active:scale-95">
                            Balikin Buku
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-24 text-center">
                    <div class="w-20 h-20 bg-[#fdf6f7] rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-ghost text-[#c65c6a]/30 text-2xl"></i>
                    </div>
                    <p class="text-gray-400 font-black uppercase tracking-[3px] text-xs italic">Kosong. Kamu tidak meminjam apapun.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection