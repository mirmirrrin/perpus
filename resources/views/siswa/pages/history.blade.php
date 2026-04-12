@extends('layouts.siswa')
@section('title', 'Riwayat Lengkap')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header Section --}}
        <header class="mb-10 flex flex-col md:flex-row justify-between items-end gap-6">
            <div>
                <div
                    class="inline-block px-4 py-1 rounded-full bg-[#fdf2f3] text-[#c65c6a] text-[10px] font-black uppercase tracking-[3px] mb-3 border border-[#c65c6a]/20">
                    History</div>
                <h2 class="text-4xl font-black text-gray-800 tracking-tighter uppercase italic">RIWAYAT <span
                        class="text-[#c65c6a]">PEMINJAMAN</span></h2>
                <p class="text-gray-400 text-[11px] font-bold uppercase tracking-[0.3em] mt-2 flex items-center gap-2">
                    <span class="w-8 h-[2px] bg-[#c65c6a]"></span>
                    Jejak seluruh peminjaman buku kamu
                </p>
            </div>
            <div class="bg-white px-8 py-5 rounded-[2rem] shadow-sm border border-gray-50 hidden md:block text-right">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Total Aktivitas</p>
                <p class="text-2xl font-black text-[#743544] tracking-tighter">{{ $myRequests->count() }} <span
                        class="text-gray-300 text-xs italic uppercase">Data</span></p>
            </div>
        </header>

        {{-- Main Table Card --}}
        <div
            class="bg-white rounded-[3rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#fcf7f8]/50 border-b border-gray-50">
                            <th class="px-10 py-8 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Buku</th>
                            <th class="px-10 py-8 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tanggal
                                Pinjam</th>
                            <th class="px-10 py-8 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status
                            </th>
                            <th class="px-10 py-8 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($myRequests as $req)
                            @php
                                // Style Badge Status
                                $statusStyles = [
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'borrowed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'rejected' => 'bg-rose-50 text-rose-600 border-rose-100',
                                    'returned' => 'bg-blue-50 text-blue-600 border-blue-100',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu',
                                    'borrowed' => 'Diterima',
                                    'rejected' => 'Ditolak',
                                    'returned' => 'Selesai',
                                ];
                            @endphp
                            <tr class="bg-white hover:bg-gray-50/50 transition-all duration-300 group">
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-5">
                                        <div
                                            class="w-12 h-12 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center group-hover:bg-[#c65c6a] group-hover:text-white transition-all duration-500">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <div>
                                            <span
                                                class="block text-gray-800 font-black text-sm uppercase tracking-tight italic">{{ $req->book->name }}</span>
                                            <span
                                                class="text-[9px] text-gray-400 font-bold tracking-[0.1em] uppercase">{{ $req->book->author }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-10 py-8">
                                    <div class="text-[11px] font-bold text-gray-600 uppercase tracking-tighter">
                                        {{ $req->created_at->format('d M Y') }}
                                        
                                    </div>
                                </td>

                                <td class="px-10 py-8">
                                    <span
                                        class="inline-flex px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest border {{ $statusStyles[$req->status] ?? 'bg-gray-50' }}">
                                        {{ $statusLabels[$req->status] ?? $req->status }}
                                    </span>
                                </td>

                                <td class="px-10 py-8 text-gray-500">
                                    @if ($req->status == 'borrowed')
                                        <div class="flex items-center gap-2 text-emerald-500">
                                            <i class="fas fa-info-circle text-[10px]"></i>
                                            <span class="text-[9px] font-black uppercase italic tracking-tighter">Batas
                                                Kembali: {{ $req->created_at->addDays(7)->format('d M Y') }}</span>
                                        </div>
                                    @elseif($req->status == 'rejected')
                                        <span
                                            class="text-[10px] italic font-medium text-rose-400">"{{ $req->rejection_reason ?? 'Stok buku habis' }}"</span>
                                    @elseif($req->status == 'returned')
                                        <span class="text-[10px] italic font-medium text-blue-400">Telah dikembalikan pada
                                            {{ $req->updated_at->format('d/m/y') }}</span>
                                    @else
                                        <span class="text-[10px] text-gray-300 italic">Menunggu konfirmasi admin...</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-32 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <i class="fas fa-history text-8xl mb-6 text-gray-400"></i>
                                        <p class="text-gray-500 font-black uppercase tracking-[0.4em] text-[10px]">Belum ada
                                            riwayat transaksi</p>
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
