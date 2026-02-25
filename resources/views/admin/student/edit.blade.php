@extends('layouts.admin')

@section('title', 'Edit Anggota')

@section('content')
<div class="w-full">
    <header class="mb-10 bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#c65c6a] flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Edit <span class="text-[#c65c6a]">Data Siswa</span></h2>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.2em] mt-1 ml-1">Perbarui profil anggota perpustakaan</p>
        </div>
        <a href="{{ route('admin.student.index') }}" class="bg-gray-50 text-[#c65c6a] px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#c65c6a] hover:text-white transition-all flex items-center gap-2 shadow-sm">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </header>

    <div class="max-w-4xl bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500">
        <form action="{{ route('admin.student.update', $student->id) }}" method="POST" class="p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Email --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Email Siswa (ID Login)</label>
                    <input type="email" name="email" value="{{ $student->email }}" required
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>

                {{-- Nama --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $student->name }}" required
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>

                {{-- Status/Role --}}
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-300 mb-3 tracking-[2px] ml-1">Status Keanggotaan</label>
                    <div class="w-full px-7 py-5 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-100 font-black text-gray-300 flex items-center gap-3 italic">
                        <i class="fas fa-lock text-xs text-gray-200"></i>
                        {{ strtoupper($student->role) }}
                        <span class="text-[8px] font-bold opacity-60 ml-auto tracking-widest uppercase">(Tidak dapat diubah)</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-8">
                <button type="submit"
                    class="flex-[2] bg-[#c65c6a] hover:bg-[#a34a56] text-white py-5 rounded-2xl font-black uppercase tracking-[2px] shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-[0.98]">
                    <i class="fas fa-sync-alt mr-2"></i> Perbarui Data Siswa
                </button>
                <a href="{{ route('admin.student.index') }}"
                    class="flex-1 bg-gray-50 text-gray-400 py-5 rounded-2xl font-black uppercase tracking-[2px] text-center flex items-center justify-center transition-all hover:bg-gray-100">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection