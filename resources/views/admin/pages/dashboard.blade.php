@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-10">
    {{-- Welcome Hero Section --}}
    <section class="bg-gradient-to-br from-[#3a1620] via-[#7a3b4b] to-[#c65c6a] rounded-[3rem] p-12 text-white relative overflow-hidden shadow-2xl shadow-[#7a3b4b]/30">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
            <div class="max-w-2xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-12 h-1 bg-[#f1c6cf] rounded-full"></span>
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#f1c6cf]">Libary Digital</p>
                </div>
                <h2 class="text-4xl md:text-5xl font-black mb-4 italic leading-tight tracking-tighter">
                    SELAMAT DATANG, <span class="text-[#f1c6cf]">ADMIN!</span>
                </h2>
                <p class="text-white/80 text-sm md:text-base font-bold leading-relaxed max-w-md">
                    Sistem berjalan optimal. Kelola koleksi buku, pantau data siswa, dan validasi transaksi pinjaman dengan satu kendali.
                </p>
            </div>

            {{-- Real-time Clock Widget --}}
            <div class="bg-black/20 backdrop-blur-md p-8 rounded-[2.5rem] border border-white/10 min-w-[240px] text-center shadow-2xl">
                <p id="admin-date" class="text-[10px] font-black uppercase tracking-[0.3em] text-[#f1c6cf] mb-2"></p>
                <h3 id="admin-clock" class="text-5xl font-black tracking-tighter tabular-nums">00:00:00</h3>
                <p class="text-[9px] font-bold uppercase tracking-widest opacity-50 mt-2">Waktu Server Aktif</p>
            </div>
        </div>

        {{-- Decorative Elements --}}
        <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-white opacity-5 rounded-full border-[20px] border-white"></div>
    </section>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Card 1: Books --}}
        <div class="bg-white rounded-[2.5rem] p-8 hover:shadow-2xl transition-all duration-500 border-b-8 border-[#c65c6a] shadow-sm group">
            <div class="flex flex-col gap-6">
                <div class="w-16 h-16 rounded-2xl bg-[#fcf7f8] text-[#c65c6a] flex items-center justify-center shadow-inner group-hover:bg-[#c65c6a] group-hover:text-white transition-all duration-500">
                    <i class="fas fa-book text-3xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.3em] mb-1">Total Koleksi</p>
                    <p class="text-4xl font-black text-gray-800 tracking-tighter italic">
                        {{ $totalBooks }} <span class="text-xs font-bold text-gray-300 uppercase not-italic">Buku</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Card 2: Active Loans --}}
        <div class="bg-white rounded-[2.5rem] p-8 hover:shadow-2xl transition-all duration-500 border-b-8 border-[#c65c6a] shadow-sm group">
            <div class="flex flex-col gap-6">
                <div class="w-16 h-16 rounded-2xl bg-[#fcf7f8] text-[#c65c6a] flex items-center justify-center shadow-inner group-hover:bg-[#c65c6a] group-hover:text-white transition-all duration-500">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.3em] mb-1">Pinjaman Aktif</p>
                    <p class="text-4xl font-black text-gray-800 tracking-tighter italic">
                        {{ $activeLoans }} <span class="text-xs font-bold text-gray-300 uppercase not-italic">Siswa</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Card 3: Students --}}
        <div class="bg-white rounded-[2.5rem] p-8 hover:shadow-2xl transition-all duration-500 border-b-8 border-[#c65c6a] shadow-sm group">
            <div class="flex flex-col gap-6">
                <div class="w-16 h-16 rounded-2xl bg-[#fcf7f8] text-[#c65c6a] flex items-center justify-center shadow-inner group-hover:bg-[#c65c6a] group-hover:text-white transition-all duration-500">
                    <i class="fas fa-user-graduate text-3xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.3em] mb-1">Total Anggota</p>
                    <p class="text-4xl font-black text-gray-800 tracking-tighter italic">
                        {{ $totalStudents }} <span class="text-xs font-bold text-gray-300 uppercase not-italic">Anggota</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateAdminClock() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        document.getElementById('admin-date').innerText = now.toLocaleDateString('id-ID', options);
        document.getElementById('admin-clock').innerText = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        });
    }
    setInterval(updateAdminClock, 1000);
    updateAdminClock();
</script>
@endsection