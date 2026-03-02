@extends('layouts.admin')

@section('title', 'Perbarui Profil Siswa')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <header class="mb-10 flex flex-col md:flex-row justify-between items-center bg-white p-8 rounded-[2rem] shadow-sm border-b-4 border-[#c65c6a] gap-4">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Edit <span class="text-[#c65c6a]">Data Siswa</span></h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1 italic ml-1">ID Anggota: #{{ $student->id }}</p>
        </div>
        <a href="{{ route('admin.student.index') }}" class="bg-gray-100 text-gray-500 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#c65c6a] hover:text-white transition-all shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </header>

    {{-- Form Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
        <div class="w-full h-2 bg-[#c65c6a]"></div>

        <form action="{{ route('admin.student.update', $student->id) }}" method="POST" class="p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Email Siswa (ID Login)</label>
                    <input type="email" name="email" value="{{ old('email', $student->email) }}" required
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>

                {{-- Nama --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}" required
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>

                {{-- tlp --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Nomor Telepon</label>
                    <div class="relative">
                        <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" placeholder="08xxxxxxxxxx"
                            class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                        <i class="fas fa-phone absolute right-6 top-1/2 -translate-y-1/2 text-[#c65c6a] opacity-20"></i>
                    </div>
                </div>

                {{-- Status Keanggotaan --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-300 tracking-widest ml-1">Status Keanggotaan</label>
                    <div class="w-full px-7 py-5 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-100 font-black text-gray-300 flex items-center gap-3 italic text-sm">
                        <i class="fas fa-lock text-xs text-gray-200"></i>
                        {{ strtoupper($student->role ?? 'STUDENT') }}
                        <span class="text-[8px] font-bold opacity-60 ml-auto tracking-widest uppercase">(System Protected)</span>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-[2] bg-[#c65c6a] hover:bg-gray-800 text-white py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                    <i class="fas fa-sync-alt"></i>
                    <span>Perbarui Data Siswa</span>
                </button>
                <a href="{{ route('admin.student.index') }}" class="flex-1 bg-gray-50 text-gray-400 py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] text-center hover:bg-gray-100 transition-all flex items-center justify-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection