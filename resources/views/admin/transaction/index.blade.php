@extends('layouts.admin')

@section('content')
<div class="w-full">
    {{-- Header Section --}}
    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm mb-8 flex flex-col lg:flex-row justify-between items-center gap-6 border-b-4 border-[#c65c6a] transition-all hover:shadow-md">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Riwayat <span class="text-[#c65c6a]">Transaksi</span></h2>
            <p class="text-sm text-gray-400 mt-1 font-bold uppercase tracking-[0.2em]">Peminjaman & Persetujuan Buku</p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-6 w-full lg:w-auto">
            <form action="" method="GET" class="relative group w-full md:w-72">
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                    placeholder="Cari transaksi..."
                    class="w-full pl-12 pr-12 py-3.5 rounded-2xl bg-[#fcf7f8] border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none text-sm font-bold transition-all shadow-inner">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-search"></i></div>
                <a href="{{ route('admin.transaction.index') }}" id="clearBtn" class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-7 h-7 flex items-center justify-center bg-gray-200 hover:bg-[#c65c6a] text-gray-500 hover:text-white rounded-lg transition-all shadow-sm"><i class="fas fa-times text-xs"></i></a>
            </form>

            <a href="{{ route('admin.transaction.create') }}" class="w-full md:w-auto bg-[#c65c6a] hover:bg-[#a34a56] text-white px-8 py-4 rounded-2xl font-bold shadow-xl transition-all active:scale-95 flex items-center justify-center gap-3 whitespace-nowrap">
                <i class="fas fa-plus-circle text-lg"></i>
                <span class="tracking-wide text-sm uppercase font-black">Tambah Transaksi</span>
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#fcf7f8]/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-6 text-[10px] font-black uppercase text-gray-400 tracking-widest text-center">No</th>
                        <th class="px-6 py-6 text-[10px] font-black uppercase text-gray-400 tracking-widest">Peminjam</th>
                        <th class="px-6 py-6 text-[10px] font-black uppercase text-gray-400 tracking-widest">Buku</th>
                        <th class="px-4 py-6 text-[10px] font-black uppercase text-gray-400 tracking-widest text-center">Tgl Pinjam</th>
                        <th class="px-4 py-6 text-[10px] font-black uppercase text-gray-400 tracking-widest text-center">Status</th>
                        <th class="px-6 py-6 text-[10px] font-black uppercase text-gray-400 tracking-widest text-center">Konfirmasi</th>
                        <th class="px-6 py-6 text-[10px] font-black uppercase text-gray-400 tracking-widest text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $index => $tr)
                    <tr class="bg-white hover:bg-gray-50 transition-all group">
                        <td class="px-6 py-6 text-center font-bold text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-6 py-6">
                            <p class="font-black text-gray-800 text-sm tracking-tight">{{ $tr->user->name ?? 'Siswa' }}</p>
                        </td>
                        <td class="px-6 py-6 font-bold text-gray-600 text-xs tracking-tight">
                            {{ Str::limit($tr->book->name ?? 'Buku', 25) }}
                        </td>
                        <td class="px-4 py-6 text-center font-bold text-gray-500 text-[11px]">
                            {{ $tr->borrowed_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-6 text-center">
                            @php
                            $colors = ['pending' => 'bg-amber-100 text-amber-600', 'borrowed' => 'bg-blue-100 text-blue-600', 'returned' => 'bg-emerald-100 text-emerald-600', 'rejected' => 'bg-rose-100 text-rose-600'];
                            @endphp
                            <span class="px-3 py-1.5 rounded-lg text-[8px] font-black uppercase tracking-widest {{ $colors[$tr->status] ?? 'bg-gray-100' }}">
                                {{ $tr->status }}
                            </span>
                        </td>
                        <td class="px-6 py-6">
                            @if($tr->status == 'pending')
                            <div class="flex flex-col gap-2 items-center mx-auto w-40">
                                <form action="{{ route('admin.transaction.approve', $tr->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white text-[9px] font-black uppercase py-2 rounded-lg transition-all shadow-md shadow-emerald-100">SETUJUI</button>
                                </form>
                                <form action="{{ route('admin.transaction.reject', $tr->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white text-[9px] font-black uppercase py-2 rounded-lg transition-all">TOLAK</button>
                                </form>
                            </div>
                            @else
                            <div class="text-center font-black text-gray-200 text-[10px] uppercase italic tracking-widest">Selesai</div>
                            @endif
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.transaction.edit', $tr->id) }}" class="w-9 h-9 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all"><i class="fas fa-edit text-xs"></i></a>
                                <form action="{{ route('admin.transaction.destroy', $tr->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-9 h-9 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all"><i class="fas fa-trash-alt text-xs"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-20 text-center opacity-20">
                            <p class="text-gray-500 font-black uppercase text-xs tracking-widest">Tidak ada riwayat transaksi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('searchInput');
        const btn = document.getElementById('clearBtn');
        const toggle = () => {
            if (input.value.length > 0) btn.classList.remove('hidden');
            else btn.classList.add('hidden');
        };
        toggle();
        input.addEventListener('input', toggle);
    });
</script>
@endsection