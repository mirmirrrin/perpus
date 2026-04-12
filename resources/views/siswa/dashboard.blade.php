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

        .maroon-gradient {
            background: linear-gradient(135deg, #743544 0%, #c65c6a 100%);
        }
    </style>

    <div class="max-w-7xl mx-auto">
        {{-- 1. LOGIKA NOTIFIKASI --}}
        @php
            $latestUpdates = \App\Models\Transaction::with('book')
                ->where('user_id', auth()->id())
                ->whereIn('status', ['borrowed', 'rejected'])
                ->where('updated_at', '>=', now()->subHours(24))
                ->latest('updated_at')
                ->get();
        @endphp

        {{-- 2. TAMPILAN ALERT --}}
        @if ($latestUpdates->count() > 0)
            {{-- Kita pakai Alpine.js supaya pas diklik langsung hilang (animasi) baru proses database --}}
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

            <div x-data="{ open: true }" x-show="open" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="mb-8 flex items-center justify-between bg-white p-4 px-8 rounded-[2rem] shadow-sm border border-gray-50 group hover:border-[#c65c6a]/20 transition-all duration-500">

                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-[#fcf7f8] rounded-2xl flex items-center justify-center text-[#c65c6a] relative">
                        <i class="fas fa-bell text-sm"></i>
                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span
                                class="relative inline-flex rounded-full h-3 w-3 bg-rose-500 border-2 border-white"></span>
                        </span>
                    </div>

                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-0.5">Notifikasi Terbaru
                        </p>
                        <p class="text-xs font-bold text-gray-700">
                            Ada <span class="text-[#c65c6a]">{{ $latestUpdates->count() }}</span> pembaruan status buku yang
                            perlu kamu cek.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <a href="#riwayat"
                        class="text-[9px] font-black uppercase tracking-widest text-gray-400 hover:text-[#c65c6a] transition-colors">
                        Lihat Riwayat
                    </a>

                    {{-- Form Dismiss dengan Route yang Benar --}}
                    <form action="{{ route('siswa.notif.dismiss') }}" method="POST" class="inline">
                        @csrf
                        <button @click="open = false" type="submit"
                            class="text-gray-400 hover:text-rose-500 transition-colors p-1 cursor-pointer outline-none">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Hero Greeting --}}
        <section
            class="maroon-gradient rounded-[3.5rem] p-12 text-white relative overflow-hidden mb-12 shadow-2xl shadow-[#743544]/30">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                <div>
                    <span
                        class="bg-white/20 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-6 inline-block border border-white/10">Selamat
                        Datang</span>
                    <h2 class="text-4xl md:text-5xl font-black mb-4 leading-tight tracking-tighter italic text-white">Halo,
                        {{ Auth::user()->name }}!</h2>
                    <p class="text-red-50 text-lg font-medium opacity-90 max-w-lg leading-relaxed">Mau baca apa hari ini?
                        Jelajahi koleksi buku dan kelola pinjamanmu dengan mudah.</p>
                </div>

                <div
                    class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-[3rem] text-center min-w-[250px]">
                    <h3 id="siswa-clock" class="text-5xl font-black tracking-tighter mb-1">00:00</h3>
                    <p id="siswa-date" class="text-[10px] font-black uppercase tracking-[0.3em] opacity-70"></p>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
        </section>

        {{-- <div class="mb-12 bg-white p-6 rounded-[2.5rem] shadow-sm border-l-[12px] border-[#743544] flex items-center gap-6 group hover:bg-[#fcf7f8] transition-all duration-300">
        <div class="w-16 h-16 bg-[#fcf7f8] rounded-[1.5rem] flex items-center justify-center text-[#c65c6a] text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div>
            <h4 class="text-xs font-black text-[#743544] uppercase tracking-[0.2em] mb-1">Informasi Aturan Peminjaman</h4>
            <p class="text-sm font-bold text-gray-600 leading-relaxed">
                Setiap peminjaman buku memiliki batas waktu maksimal <span class="text-[#c65c6a] font-black underline decoration-2 underline-offset-4">7 HARI</span> sejak tanggal disetujui. 
                <span class="block md:inline md:ml-1 text-[10px] text-gray-400 font-medium italic">Harap mengembalikan buku dengan tepat waktu.</span>
            </p>
        </div>
    </div> --}}

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center gap-6 hover-lift">
                <div
                    class="w-16 h-16 bg-orange-50 text-orange-500 rounded-3xl flex items-center justify-center text-2xl shadow-inner">
                    <i class="fas fa-book-reader"></i></div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pinjaman Aktif</p>
                    <p class="text-3xl font-black text-gray-800">{{ $activeBorrowCount ?? 0 }} <span
                            class="text-sm text-gray-300">Buku</span></p>
                </div>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center gap-6 hover-lift">
                <div
                    class="w-16 h-16 bg-rose-50 text-[#c65c6a] rounded-3xl flex items-center justify-center text-2xl shadow-inner">
                    <i class="fas fa-history"></i></div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Riwayat</p>
                    <p class="text-3xl font-black text-gray-800">{{ $myRequests->count() }} <span
                            class="text-sm text-gray-300">Data</span></p>
                </div>
            </div>
        </div>

        {{-- Recent Requests (Riwayat) --}}
        <div id="riwayat" class="mb-6 flex justify-between items-center">
            <h3 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Status Permintaan <span
                    class="text-[#c65c6a]">Terbaru</span></h3>
        </div>

        <div class="grid grid-cols-1 gap-5">
            @forelse($myRequests->take(5) as $req)
                <div
                    class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4 group transition-all hover:bg-gray-50">
                    <div class="flex items-center gap-5">
                        <div
                            class="w-14 h-14 bg-[#fcf7f8] rounded-2xl flex items-center justify-center group-hover:bg-[#c65c6a] transition-colors duration-500">
                            <i class="fas fa-book text-[#c65c6a] group-hover:text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-gray-800 text-sm uppercase tracking-tight">{{ $req->book->name }}
                            </h4>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Diajukan:
                                {{ $req->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    @php
                        $statusStyles = [
                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'borrowed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'rejected' => 'bg-rose-50 text-rose-600 border-rose-100',
                            'returned' => 'bg-blue-50 text-blue-600 border-blue-100',
                        ];
                        $statusLabels = [
                            'pending' => 'Menunggu',
                            'borrowed' => 'Diterima',
                            'rejected' => 'Ditolak',
                            'returned' => 'Selesai',
                        ];
                    @endphp

                    <div class="flex flex-col md:items-end gap-2">
                        <span
                            class="{{ $statusStyles[$req->status] ?? 'bg-gray-50' }} border px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest">
                            {{ $statusLabels[$req->status] ?? $req->status }}
                        </span>

                        {{-- LOGIKA TANGGAL TENGGAT OTOMATIS --}}
                        @if ($req->status == 'borrowed')
                            <p class="text-[9px] text-emerald-500 font-black italic uppercase tracking-tighter">
                                <i class="fas fa-clock mr-1"></i> Tenggat:
                                {{ $req->created_at->addDays(7)->format('d M Y') }}
                            </p>
                        @elseif($req->status == 'rejected')
                            <p class="text-[10px] text-rose-400 italic font-medium">
                                "{{ $req->rejection_reason ?? 'Stok tidak mencukupi' }}"</p>
                        @endif
                    </div>
                </div>
    @empty
        <div
            class="bg-white p-20 rounded-[3rem] text-center border-2 border-dashed border-gray-100 flex flex-col items-center">
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
