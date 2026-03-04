@extends('layouts.siswa')
@section('title', 'Dashboard')

@section('content')
<style>
    .hover-lift {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(116, 53, 68, 0.15);
    }
</style>

<div class="max-w-7xl mx-auto">

    {{-- ALERT NOTIFIKASI SISWA: STATUS TERBARU --}}
    @php
    $hasUpdate = \App\Models\Transaction::where('user_id', auth()->id())
    ->whereIn('status', ['borrowed', 'rejected', 'returned'])
    ->where('updated_at', '>=', now()->subHours(24))
    ->exists();
    @endphp

    @if($hasUpdate)
    {{-- Tambahkan id="global-alert" supaya bisa dipanggil sama JavaScript --}}
    <div id="global-alert" style="display: none;" class="mb-8 p-6 bg-gradient-to-r from-[#743544] to-[#c65c6a] rounded-[2.5rem] text-white shadow-xl shadow-[#743544]/20 flex items-center justify-between group relative transition-all duration-500 overflow-hidden">
        <div class="flex items-center gap-5">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center border border-white/30">
                <i class="fas fa-info-circle text-lg"></i>
            </div>
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.2em] opacity-80 italic">Pemberitahuan Sistem</p>
                <h4 class="font-bold text-sm tracking-tight">
                    Status peminjaman buku Anda telah diperbarui oleh Admin!
                </h4>
                <p class="text-[10px] opacity-60 font-medium">Silakan cek detail status pada tabel di bawah ini.</p>
            </div>
        </div>

        {{-- Tombol Silang (Close) --}}
        <button onclick="closeAlert()" class="w-10 h-10 rounded-2xl bg-black/10 hover:bg-white/20 flex items-center justify-center transition-all border border-white/10 group-hover:rotate-90">
            <i class="fas fa-times text-xs"></i>
        </button>

        {{-- Efek Dekorasi biar makin cakep --}}
        <div class="absolute -right-4 -top-4 w-12 h-12 bg-white opacity-5 rounded-full"></div>
    </div>

    <script>
        function closeAlert() {
            const alertBox = document.getElementById('global-alert');
            // Kasih efek transisi sedikit pas hilang
            alertBox.style.opacity = '0';
            alertBox.style.transform = 'translateY(-20px)';

            // Setelah animasi selesai, baru bener-bener dihapus dari tampilan
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 500);
        }
    </script>
    @endif

    {{-- Hero Greeting --}}
    <section class="maroon-gradient rounded-[3.5rem] p-12 text-white relative overflow-hidden mb-12 shadow-2xl shadow-[#743544]/30">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
            <div>
                <span class="bg-white/20 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-6 inline-block border border-white/10">Selamat Datang</span>
                <h2 class="text-4xl md:text-5xl font-black mb-4 leading-tight tracking-tighter italic text-white">Halo, {{ Auth::user()->name }}!</h2>
                <p class="text-red-50 text-lg font-medium opacity-90 max-w-lg leading-relaxed">Mau baca apa hari ini? Jelajahi koleksi buku dan kelola pinjamanmu dengan mudah.</p>
            </div>

            {{-- Real-time Clock Siswa --}}
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-[3rem] text-center min-w-[250px]">
                <h3 id="siswa-clock" class="text-5xl font-black tracking-tighter mb-1">00:00</h3>
                <p id="siswa-date" class="text-[10px] font-black uppercase tracking-[0.3em] opacity-70"></p>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
    </section>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center gap-6 hover-lift">
            <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-3xl flex items-center justify-center text-2xl shadow-inner"><i class="fas fa-book-reader"></i></div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pinjaman Aktif</p>
                <p class="text-3xl font-black text-gray-800">{{ $activeBorrowCount ?? 0 }} <span class="text-sm text-gray-300">Buku</span></p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center gap-6 hover-lift">
            <div class="w-16 h-16 bg-rose-50 text-[#c65c6a] rounded-3xl flex items-center justify-center text-2xl shadow-inner"><i class="fas fa-history"></i></div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Riwayat</p>
                <p class="text-3xl font-black text-gray-800">{{ $myRequests->count() }} <span class="text-sm text-gray-300">Data</span></p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center gap-6 hover-lift">
            <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-3xl flex items-center justify-center text-2xl shadow-inner"><i class="fas fa-user-check"></i></div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status Akun</p>
                <p class="text-lg font-black text-blue-600 uppercase italic tracking-tighter">Siswa Aktif</p>
            </div>
        </div>
    </div>

    {{-- Recent Requests Table/List --}}
    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Status Permintaan <span class="text-[#c65c6a]">Terbaru</span></h3>
    </div>

    <div class="grid grid-cols-1 gap-5">
        @forelse($myRequests->take(5) as $req)
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4 group transition-all hover:bg-gray-50">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-[#fcf7f8] rounded-2xl flex items-center justify-center group-hover:bg-[#c65c6a] transition-colors duration-500">
                    <i class="fas fa-book text-[#c65c6a] group-hover:text-white"></i>
                </div>
                <div>
                    <h4 class="font-black text-gray-800 text-sm uppercase tracking-tight">{{ $req->book->name }}</h4>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Diajukan: {{ $req->created_at->format('d M Y') }}</p>
                </div>
            </div>

            @php
            $statusStyles = [
            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
            'borrowed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
            'rejected' => 'bg-rose-50 text-rose-600 border-rose-100',
            'returned' => 'bg-blue-50 text-blue-600 border-blue-100'
            ];
            $statusLabels = ['pending' => 'Menunggu', 'borrowed' => 'Diterima', 'rejected' => 'Ditolak', 'returned' => 'Selesai'];
            @endphp

            <div class="flex flex-col md:items-end gap-2">
                <span class="{{ $statusStyles[$req->status] ?? 'bg-gray-50' }} border px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest">
                    {{ $statusLabels[$req->status] ?? $req->status }}
                </span>
                @if($req->status == 'rejected')
                <p class="text-[10px] text-rose-400 italic font-medium">"{{ $req->rejection_reason ?? 'Stok tidak mencukupi' }}"</p>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white p-20 rounded-[3rem] text-center border-2 border-dashed border-gray-100 flex flex-col items-center">
            <i class="fas fa-folder-open text-gray-200 text-5xl mb-4"></i>
            <p class="text-gray-400 font-bold text-[10px] uppercase tracking-[0.3em]">Belum ada riwayat permintaan</p>
        </div>
        @endforelse
    </div>
</div>

<script>
    function updateSiswaClock() {
        const now = new Date();
        const options = {
            weekday: 'short',
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        };

        document.getElementById('siswa-date').innerText = now.toLocaleDateString('id-ID', options);
        document.getElementById('siswa-clock').innerText = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        });
    }
    setInterval(updateSiswaClock, 1000);
    updateSiswaClock();
</script>
@endsection