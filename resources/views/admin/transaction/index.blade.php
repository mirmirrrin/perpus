@extends('layouts.admin')

@section('title', 'Data Riwayat Transaksi')

@section('content')
<div class="max-w-7xl mx-auto space-y-10">
    {{-- Header Section --}}
    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border-b-8 border-[#c65c6a] flex flex-col lg:flex-row justify-between items-center gap-8 transition-all hover:shadow-md">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-10 h-[3px] bg-[#c65c6a] rounded-full"></span>
                <p class="text-[10px] font-black text-[#c65c6a] uppercase tracking-[0.3em]">Log Perputaran Buku</p>
            </div>
            <h2 class="text-4xl font-black text-gray-800 tracking-tighter uppercase italic">Data <span class="text-[#c65c6a]">Transaksi</span></h2>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-5 w-full lg:w-auto">
            <form action="{{ route('admin.transaction.index') }}" method="GET" class="relative group w-full md:w-80">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peminjam..."
                    class="w-full pl-12 pr-12 py-4 rounded-2xl bg-[#fcf7f8] border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none text-sm font-bold transition-all shadow-inner">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#c65c6a]">
                    <i class="fas fa-search"></i>
                </div>
            </form>

            <a href="{{ route('admin.transaction.create') }}" class="w-full md:w-auto bg-[#c65c6a] hover:bg-gray-800 text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                <i class="fas fa-plus-circle text-lg"></i>
                <span class="tracking-widest text-[11px] uppercase whitespace-nowrap">Tambah Transaksi</span>
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[3rem] shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcf7f8]/50 border-b border-gray-50">
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">No</th>
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Peminjam</th>
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Judul Buku</th>
                        <th class="px-6 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Tanggal</th>
                        <th class="px-6 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Status</th>
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Konfirmasi</th>
                        <th class="px-8 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $index => $tr)
                    @php
                    $tenggat = \Carbon\Carbon::parse($tr->returned_at);
                    $isTerlambat = now()->gt($tenggat) && $tr->status == 'borrowed';
                    @endphp
                    <tr class="bg-white hover:bg-gray-50 hover:shadow-xl hover:shadow-gray-100 hover:scale-[1.01] transition-all duration-300 group cursor-default">
                        <td class="px-8 py-6 text-center">
                            <span class="bg-[#fdf2f3] text-[#c65c6a] px-3 py-1.5 rounded-lg font-black text-[10px] border border-[#f5e1e4]">
                                {{ sprintf('%02d', $index + 1) }}
                            </span>
                        </td>

                        {{-- Kolom Peminjam Terpisah --}}
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 bg-[#c65c6a]/20 rounded-full group-hover:bg-[#c65c6a] transition-all"></div>
                                <span class="text-sm font-black text-gray-800 font black tracking-tight group-hover:text-[#c65c6a] transition-colors">
                                    {{ $tr->user->name ?? 'Siswa' }}
                                </span>
                            </div>
                        </td>

                        {{-- Kolom Buku Terpisah --}}
                        <td class="px-8 py-6">
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide leading-relaxed">
                                <i class="fas fa-book-open mr-2 text-[#c65c6a]/40 group-hover:text-[#c65c6a]"></i>
                                {{ Str::limit($tr->book->name ?? 'Buku Tidak Ditemukan', 35) }}
                            </p>
                        </td>

                        <td class="px-6 py-6 text-center">
                            <div class="flex flex-col items-center">
                                <span class="font-black text-gray-700 text-[11px] tracking-tighter">{{ $tr->borrowed_at->format('d/m/Y') }}</span>
                                @if($isTerlambat)
                                <span class="mt-1 text-rose-500 text-[7px] font-black uppercase tracking-widest animate-pulse italic">Terlambat!</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-6 text-center">
                            @php
                            $colors = [
                            'pending' => 'bg-amber-100/50 text-amber-600 border-amber-200',
                            'borrowed' => 'bg-blue-100/50 text-blue-600 border-blue-200',
                            'returned' => 'bg-emerald-100/50 text-emerald-600 border-emerald-200',
                            'rejected' => 'bg-rose-100/50 text-rose-600 border-rose-200'
                            ];
                            @endphp
                            <span class="px-3 py-1.5 rounded-xl text-[8px] font-black uppercase tracking-widest border {{ $colors[$tr->status] ?? 'bg-gray-100' }}">
                                {{ $tr->status }}
                            </span>
                        </td>

                        <td class="px-8 py-6 text-center">
                            @if($tr->status == 'pending')
                            <div class="flex flex-col gap-1.5 min-w-[120px]">
                                <form action="{{ route('admin.transaction.approve', $tr->id) }}" method="POST">
                                    @csrf
                                    <button class="w-full bg-emerald-500 text-white text-[9px] font-black uppercase py-2 rounded-lg hover:bg-emerald-600 transition-all shadow-sm">Setujui</button>
                                </form>
                                <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full bg-rose-50 text-rose-500 text-[9px] font-black uppercase py-2 rounded-lg hover:bg-rose-500 hover:text-white transition-all">Tolak</button>
                                <form action="{{ route('admin.transaction.reject', $tr->id) }}" method="POST" class="hidden mt-2">
                                    @csrf
                                    <input type="text" name="rejection_reason_manual" placeholder="Alasan..." class="w-full text-[9px] p-2 border border-rose-200 rounded-lg mb-1 focus:outline-none">
                                    <button type="submit" class="w-full bg-rose-600 text-white text-[8px] font-black py-1.5 rounded-lg">Kirim</button>
                                </form>
                            </div>
                            @else
                            <span class="text-[9px] font-black text-gray-300 uppercase italic">Processed</span>
                            @endif
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.transaction.edit', $tr->id) }}" class="w-9 h-9 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.transaction.destroy', $tr->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi?')">
                                    @csrf @method('DELETE')
                                    <button class="w-9 h-9 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-32 text-center opacity-20">
                            <i class="fas fa-receipt text-7xl mb-6"></i>
                            <p class="text-[11px] font-black uppercase tracking-[0.4em]">Belum Ada Riwayat</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection