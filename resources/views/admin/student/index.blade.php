@extends('layouts.admin')

@section('title', 'Data Anggota Siswa')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header Section --}}
    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm mb-10 border-b-8 border-[#c65c6a] flex flex-col lg:flex-row justify-between items-center gap-8 transition-all hover:shadow-md">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-10 h-[3px] bg-[#c65c6a] rounded-full"></span>
                <p class="text-[10px] font-black text-[#c65c6a] uppercase tracking-[0.3em]">Master Data Anggota</p>
            </div>
            <h2 class="text-4xl font-black text-gray-800 tracking-tighter uppercase italic">Data <span class="text-[#c65c6a]">Siswa</span></h2>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-5 w-full lg:w-auto">
            <form action="{{ route('admin.student.index') }}" method="GET" class="relative group w-full md:w-80">
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                    class="w-full pl-12 pr-12 py-4 rounded-2xl bg-[#fcf7f8] border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none text-sm font-bold transition-all shadow-inner">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#c65c6a]">
                    <i class="fas fa-search"></i>
                </div>
            </form>

            <a href="{{ route('admin.student.create') }}" class="w-full md:w-auto bg-[#c65c6a] hover:bg-gray-800 text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                <i class="fas fa-user-plus text-lg"></i>
                <span class="tracking-widest text-[11px] uppercase whitespace-nowrap">Tambah Siswa</span>
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[3rem] shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcf7f8]/50 border-b border-gray-50">
                        <th class="px-10 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] w-32">ID Siswa</th>
                        <th class="px-10 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Nama Lengkap</th>
                        <th class="px-10 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Akun Email</th>
                        <th class="px-10 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Kontak</th>
                        <th class="px-10 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($students as $student)
                    <tr class="bg-white hover:bg-gray-50 transition-all duration-300 group">
                        <td class="px-10 py-6">
                            <span class="bg-[#fdf2f3] text-[#c65c6a] px-4 py-2 rounded-xl font-black text-[10px] border border-[#f5e1e4] shadow-sm">
                                #{{ $student->id }}
                            </span>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 bg-[#c65c6a]/20 rounded-full group-hover:bg-[#c65c6a] transition-all"></div>
                                <span class="text-sm font-black text-gray-800 tracking-tight group-hover:text-[#c65c6a] transition-colors uppercase italic">
                                    {{ $student->name }}
                                </span>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <p class="text-sm text-gray-500 font-bold italic opacity-70">{{ $student->email }}</p>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-gray-700 tracking-tight italic">
                                    {{ $student->phone ?? '-' }}
                                </span>
                                <span class="text-[8px] font-bold text-[#c65c6a] uppercase tracking-[0.2em] opacity-50">
                                    Student Contact
                                </span>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('admin.student.edit', $student->id) }}"
                                    class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-user-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.student.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-10 h-10 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-32 text-center">
                            <div class="opacity-20 flex flex-col items-center">
                                <i class="fas fa-users-slash text-7xl mb-6 text-gray-300"></i>
                                <p class="text-[11px] font-black uppercase tracking-[0.4em]">Siswa Tidak Terdaftar</p>
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