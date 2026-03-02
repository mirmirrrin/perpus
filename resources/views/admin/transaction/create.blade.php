@extends('layouts.admin')

@section('title', 'Tambah Transaksi Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <header class="mb-10 bg-white p-8 rounded-[2rem] shadow-sm border-b-4 border-[#c65c6a] flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase italic">Tambah <span class="text-[#c65c6a]">Pinjaman</span></h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1 italic">Input data peminjaman koleksi baru</p>
        </div>
        <a href="{{ route('admin.transaction.index') }}" class="bg-gray-50 text-gray-400 px-6 py-3 rounded-xl font-black text-[10px] hover:bg-[#c65c6a] hover:text-white transition-all uppercase tracking-widest shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </header>

    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
        <div class="w-full h-2 bg-[#c65c6a]"></div>
        <form action="{{ route('admin.transaction.store') }}" method="POST" class="p-10 space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Siswa --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Peminjam (Siswa)</label>
                    <div class="relative">
                        <input type="text" name="student_name" list="student_list" required placeholder="Cari nama siswa..."
                            class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                        <i class="fas fa-search absolute right-6 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                    <datalist id="student_list">
                        @foreach($students as $s) <option value="{{ $s->name }}"> @endforeach
                    </datalist>
                </div>

                {{-- Buku --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Koleksi Buku</label>
                    <div class="relative">
                        <input type="text" name="book_name" list="book_list" required placeholder="Cari judul buku..."
                            class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                        <i class="fas fa-book absolute right-6 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    </div>
                    <datalist id="book_list">
                        @foreach($books as $b) <option value="{{ $b->name }}"> @endforeach
                    </datalist>
                </div>

                {{-- Tanggal --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Mulai Pinjam</label>
                    <input type="date" name="borrowed_at" value="{{ date('Y-m-d') }}"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white font-bold text-gray-700 transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-rose-400 tracking-widest ml-1">Batas Kembali</label>
                    <input type="date" name="returned_at" value="{{ date('Y-m-d', strtotime('+3 days')) }}"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white font-bold text-gray-700 transition-all">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#c65c6a] hover:bg-gray-800 text-white py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                <i class="fas fa-check-circle"></i>
                <span>Konfirmasi Peminjaman</span>
            </button>
        </form>
    </div>
</div>
@endsection