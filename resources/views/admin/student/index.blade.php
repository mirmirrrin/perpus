@extends('layouts.admin')

@section('title', 'Data Anggota')

@section('content')
<div class="w-full">
    {{-- Header Section --}}
    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm mb-8 flex flex-col lg:flex-row justify-between items-center gap-6 border-b-4 border-[#c65c6a] transition-all hover:shadow-md">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Data <span class="text-[#c65c6a]">Siswa</span></h2>
            <p class="text-sm text-gray-400 mt-1 font-bold uppercase tracking-[0.2em]">Manajemen Anggota Perpustakaan</p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-6 w-full lg:w-auto">
            {{-- Form Search Bar --}}
            <form action="" method="GET" class="relative group w-full md:w-72">
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                    placeholder="Cari data siswa..."
                    class="w-full pl-12 pr-12 py-3.5 rounded-2xl bg-[#fcf7f8] border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none text-sm font-bold transition-all shadow-inner">

                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>

                <a href="{{ route('admin.student.index') }}" id="clearBtn"
                    class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-7 h-7 flex items-center justify-center bg-gray-200 hover:bg-[#c65c6a] text-gray-500 hover:text-white rounded-lg transition-all shadow-sm">
                    <i class="fas fa-times text-xs"></i>
                </a>
            </form>

            <a href="{{ route('admin.student.create') }}" class="w-full md:w-auto bg-[#c65c6a] hover:bg-[#a34a56] text-white px-8 py-4 rounded-2xl font-bold shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3 whitespace-nowrap">
                <i class="fas fa-plus-circle text-lg"></i>
                <span class="tracking-wide text-sm uppercase font-black">Tambah Siswa</span>
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
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] w-24">ID</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Nama Lengkap</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Email Akun</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($students as $student)
                    <tr class="bg-white hover:bg-gray-50 hover:shadow-xl hover:shadow-gray-100 hover:scale-[1.01] transition-all duration-300 group cursor-default">
                        <td class="px-8 py-6">
                            <span class="bg-[#fdf2f3] text-[#c65c6a] px-3 py-1.5 rounded-xl font-black text-[10px] border border-[#f5e1e4]">#{{ $student->id }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-[#c65c6a]/20 rounded-full group-hover:bg-[#c65c6a] transition-all"></div>
                                <span class="text-sm font-bold text-gray-800 group-hover:text-[#c65c6a] transition-colors tracking-tight">{{ $student->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm text-gray-500 font-medium italic">{{ $student->email }}</td>
                        <td class="px-8 py-6">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('admin.student.edit', $student->id) }}" class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all shadow-sm"><i class="fas fa-edit text-xs"></i></a>
                                <form action="{{ route('admin.student.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?')">
                                    @csrf @method('DELETE')
                                    <button class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm"><i class="fas fa-trash text-xs"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-32 text-center opacity-20">
                            <i class="fas fa-users-slash text-8xl mb-6 text-gray-300"></i>
                            <p class="text-gray-500 font-black uppercase tracking-[0.3em]">Siswa Tidak Ditemukan</p>
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