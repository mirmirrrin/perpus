@extends('layouts.admin')

@section('title', 'Registrasi Anggota Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <header class="mb-10 flex flex-col md:flex-row justify-between items-center bg-white p-8 rounded-[2rem] shadow-sm border-b-4 border-[#c65c6a] gap-4">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Registrasi <span class="text-[#c65c6a]">Anggota Baru</span></h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1 italic ml-1">Daftarkan siswa ke dalam sistem perpustakaan</p>
        </div>
        <a href="{{ route('admin.student.index') }}" class="bg-gray-100 text-gray-500 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#c65c6a] hover:text-white transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </header>

    {{-- Error Notification --}}
    @if ($errors->any())
    <div class="mb-8 p-6 bg-rose-50 rounded-[2rem] border-l-8 border-[#c65c6a] animate-head-shake">
        <div class="flex items-center gap-4">
            <i class="fas fa-exclamation-triangle text-[#c65c6a] text-xl"></i>
            <div>
                <p class="font-black text-xs text-[#c65c6a] uppercase tracking-widest">Kesalahan Input Terdeteksi</p>
                <ul class="text-[10px] font-bold text-rose-400 mt-1">
                    @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-50 overflow-hidden">
        <div class="w-full h-2 bg-[#c65c6a]"></div>

        <form action="{{ route('admin.student.store') }}" method="POST" class="p-10 space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Nama Lengkap --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Nama Lengkap Siswa</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan Nama Lengkap"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>

                {{-- Username --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Username Akun</label>
                    <input type="text" name="username" value="{{ old('username') }}" required placeholder="Masukkan Username"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>

                {{-- Kelas --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Kelas / Jurusan</label>
                    <input type="text" name="class" value="{{ old('class') }}" required placeholder="Masukkan Kelas"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>

                <div class="mb-6">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Nomor Telepon / WA</label>
                    <div class="relative">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-[#c65c6a]">
                            <i class="fas fa-phone-alt text-xs"></i>
                        </div>
                        <input type="text" name="phone" placeholder="0812xxxx" required
                            class="w-full pl-12 pr-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-[#c65c6a] font-bold text-sm text-gray-700 transition-all">
                    </div>
                </div>

                {{-- Email --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Alamat Email (Login Utama)</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>

                {{-- Password --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Password Akun</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter unik"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-[2] bg-[#c65c6a] hover:bg-gray-800 text-white py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                    <i class="fas fa-save"></i>
                    <span>Simpan Data Anggota</span>
                </button>
                <a href="{{ route('admin.student.index') }}" class="flex-1 bg-gray-50 text-gray-400 py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] text-center hover:bg-gray-100 transition-all flex items-center justify-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection