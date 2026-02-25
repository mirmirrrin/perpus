@extends('layouts.admin')

@section('content')
<div class="w-full">
    <header class="mb-10 bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#c65c6a] flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Registrasi <span class="text-[#c65c6a]">Anggota</span></h2>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.2em] mt-1 ml-1">Input data siswa baru ke sistem</p>
        </div>
        <a href="{{ route('admin.student.index') }}" class="bg-gray-50 text-[#c65c6a] px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#c65c6a] hover:text-white transition-all flex items-center gap-2 shadow-sm">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </header>

    @if ($errors->any())
    <div class="max-w-4xl mb-8 p-5 bg-red-50 rounded-2xl border-l-8 border-red-500 text-red-700 animate-head-shake">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-xl"></i>
            <div>
                <p class="font-black text-xs uppercase tracking-widest">Terjadi Kesalahan Input</p>
                <ul class="text-[11px] font-bold opacity-80 mt-1">
                    @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="max-w-4xl bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500">
        <form action="{{ route('admin.student.store') }}" method="POST" class="p-10 space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Nama Lengkap --}}
                <div class="md:col-span-2 group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Nama Lengkap Siswa</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all placeholder:text-gray-300 shadow-sm" placeholder="Masukkan Nama Lengkap">
                </div>

                {{-- Username --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm" placeholder="Masukkan Username">
                </div>

                {{-- Kelas --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Kelas / Jurusan</label>
                    <input type="text" name="class" value="{{ old('class') }}" required
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm" placeholder="Masukkan Kelas">
                </div>

                {{-- Email --}}
                <div class="md:col-span-2 group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Alamat Email (Login Utama)</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm" placeholder="nama@email.com">
                </div>

                {{-- Password --}}
                <div class="md:col-span-2 group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Password Akun</label>
                    <input type="password" name="password" required
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm" placeholder="Minimal 8 karakter unik">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit" class="flex-[2] bg-[#c65c6a] text-white py-5 rounded-2xl font-black uppercase tracking-[2px] shadow-xl shadow-[#c65c6a]/20 hover:bg-[#a34a56] transition-all active:scale-[0.98]">
                    <i class="fas fa-user-plus mr-2"></i> Simpan Data Anggota
                </button>
                <a href="{{ route('admin.student.index') }}" class="flex-1 bg-gray-50 text-gray-400 py-5 rounded-2xl font-black uppercase tracking-[2px] text-center flex items-center justify-center hover:bg-gray-100 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection 