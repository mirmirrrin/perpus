@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<section class="bg-gradient-to-br from-[#7a3b4b] to-[#c65c6a] rounded-[2.5rem] p-10 text-white relative overflow-hidden mb-10 shadow-2xl shadow-[#7a3b4b]/20">
    <div class="relative z-10 max-w-2xl">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-3 italic leading-tight">Selamat Datang, Admin!</h2>
        <p class="text-red-50 text-sm md:text-base font-medium opacity-90">
            Sistem perpustakaan berjalan normal. Gunakan menu navigasi untuk mengelola koleksi buku, data siswa, dan pantau seluruh transaksi hari ini.
        </p>
    </div>
    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white opacity-10 rounded-full"></div>
    <div class="absolute right-20 top-5 w-20 h-20 bg-white opacity-5 rounded-full"></div>
</section>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 border-l-8 border-[#c65c6a] shadow-sm group">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-[#fcf7f8] text-[#c65c6a] flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                <i class="fas fa-book text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Koleksi</p>
                <p class="text-3xl font-black text-gray-800">{{ $totalBooks }} <span class="text-xs font-bold text-gray-300 uppercase">Buku</span></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 border-l-8 border-[#c65c6a] shadow-sm group">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-[#fcf7f8] text-[#c65c6a] flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Pinjaman Aktif</p>
                <p class="text-3xl font-black text-gray-800">{{ $activeLoans }} <span class="text-xs font-bold text-gray-300 uppercase">Siswa</span></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 border-l-8 border-[#c65c6a] shadow-sm group">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-[#fcf7f8] text-[#c65c6a] flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                <i class="fas fa-user-graduate text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Anggota</p>
                <p class="text-3xl font-black text-gray-800">{{ $totalStudents }} <span class="text-xs font-bold text-gray-300 uppercase">Anggota</span></p>
            </div>
        </div>
    </div>
</div>
@endsection