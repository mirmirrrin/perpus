@extends('layouts.admin')

@section('title', 'Kelola Buku')

@section('content')
<div class="w-full">
    {{-- Header Section --}}
    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm mb-8 flex flex-col lg:flex-row justify-between items-center gap-6 border-b-4 border-[#c65c6a] transition-all hover:shadow-md">

        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Kelola <span class="text-[#c65c6a]">Buku</span></h2>
            <p class="text-sm text-gray-400 mt-1 font-bold uppercase tracking-[0.2em]">Manajemen Koleksi Perpustakaan</p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-6 w-full lg:w-auto">

            <div class="text-right hidden xl:block">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Hari Ini</p>
                <p class="text-sm font-black text-[#c65c6a]">{{ date('l, d F Y') }}</p>
            </div>

            {{-- Form Search --}}
            <form action="" method="GET" class="relative group w-full md:w-72">
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                    placeholder="Cari data buku..."
                    class="w-full pl-12 pr-12 py-3.5 rounded-2xl bg-[#fcf7f8] border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none text-sm font-bold transition-all shadow-inner">

                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>

                <a href="{{ route('admin.book.index') }}" id="clearBtn"
                    class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-7 h-7 flex items-center justify-center bg-gray-200 hover:bg-[#c65c6a] text-gray-500 hover:text-white rounded-lg transition-all shadow-sm">
                    <i class="fas fa-times text-xs"></i>
                </a>
            </form>

            <a href="{{ route('admin.book.create') }}" class="w-full md:w-auto bg-[#c65c6a] hover:bg-[#a34a56] text-white px-8 py-4 rounded-2xl font-bold shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3 whitespace-nowrap">
                <i class="fas fa-plus-circle text-lg"></i>
                <span class="tracking-wide text-sm uppercase font-black">Tambah Buku</span>
            </a>
        </div>
    </div>

    @if(request('search'))
    <div class="mb-6 px-4">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
            Hasil pencarian untuk: <span class="text-[#c65c6a]">"{{ request('search') }}"</span>
        </p>
    </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#fcf7f8]/50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Info Judul</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Kategori</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Penulis</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Penerbit</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Stok</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($books as $book)
                    <tr class="bg-white hover:bg-gray-50 hover:shadow-xl hover:shadow-gray-100 hover:scale-[1.01] transition-all duration-300 group cursor-default">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-[#c65c6a]/20 rounded-full group-hover:bg-[#c65c6a] transition-all"></div>
                                <span class="text-sm font-bold text-gray-800 group-hover:text-[#c65c6a] transition-colors tracking-tight">{{ $book->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 bg-[#fdf2f3] text-[#c65c6a] text-[10px] font-black uppercase rounded-xl border border-[#f5e1e4] tracking-wider">
                                {{ $book->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm text-gray-600 font-bold italic tracking-tight">{{ $book->author ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.1em]">{{ $book->publisher ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="font-black text-lg text-[#c65c6a]">{{ $book->stock }}</span>
                            <span class="text-[8px] text-gray-300 font-black uppercase ml-1 tracking-tighter">Unit</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('admin.book.edit', $book->id) }}"
                                    class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.book.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Hapus buku ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-32 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <i class="fas fa-layer-group text-8xl mb-6 text-gray-300"></i>
                                <p class="text-gray-500 font-black uppercase tracking-[0.3em]">Koleksi Kosong</p>
                            </div>
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
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearBtn');
        if (searchInput && clearBtn) {
            const toggleBtn = () => {
                if (searchInput.value.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            };
            toggleBtn();
            searchInput.addEventListener('input', toggleBtn);
        }
    });
</script>
@endsection