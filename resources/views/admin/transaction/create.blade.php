@extends('layouts.admin')

@section('content')
<div class="w-full">
    <header class="mb-10 bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#c65c6a] flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Tambah <span class="text-[#c65c6a]">Transaksi</span></h2>
            <p class="text-sm text-gray-400 mt-1 font-bold uppercase tracking-widest">Pencatatan peminjaman koleksi baru</p>
        </div>
        <a href="{{ route('admin.transaction.index') }}" class="bg-gray-50 text-[#c65c6a] px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#c65c6a] hover:text-white transition-all flex items-center gap-2">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </header>

    <div class="max-w-5xl bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500">
        <form action="{{ route('admin.transaction.store') }}" method="POST" class="p-10 space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                {{-- Nama Siswa --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Nama Peminjam (Siswa)</label>
                    <div class="relative">
                        <input type="text" name="student_name" list="student_list"
                            class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm"
                            placeholder="Cari nama siswa..." required autocomplete="off">
                        <i class="fas fa-search absolute right-6 top-6 text-gray-300"></i>
                    </div>
                    <datalist id="student_list">
                        @foreach($students as $s) <option value="{{ $s->name }}"> @endforeach
                    </datalist>
                </div>

                {{-- Judul Buku --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Koleksi Buku</label>
                    <div class="relative">
                        <input type="text" name="book_name" list="book_list"
                            class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm"
                            placeholder="Cari judul buku..." required autocomplete="off">
                        <i class="fas fa-book absolute right-6 top-6 text-gray-300"></i>
                    </div>
                    <datalist id="book_list">
                        @foreach($books as $b) <option value="{{ $b->name }}"> @endforeach
                    </datalist>
                </div>

                {{-- Tanggal Pinjam --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Tanggal Mulai Pinjam</label>
                    <input type="date" name="borrowed_at" value="{{ date('Y-m-d') }}"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm">
                </div>

                {{-- Tanggal Tenggat --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-[2px] ml-1">Tenggat Pengembalian</label>
                    <input type="date" name="returned_at" value="{{ date('Y-m-d', strtotime('+3 days')) }}"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm border-b-4 border-rose-100">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit" class="flex-[2] bg-[#c65c6a] text-white py-5 rounded-2xl font-black uppercase tracking-[2px] shadow-xl shadow-[#c65c6a]/20 hover:bg-[#a34a56] transition-all active:scale-[0.98]">
                    <i class="fas fa-check-circle mr-2"></i> Konfirmasi Peminjaman
                </button>
                <a href="{{ route('admin.transaction.index') }}" class="flex-1 bg-gray-50 text-gray-400 py-5 rounded-2xl font-black uppercase tracking-[2px] text-center flex items-center justify-center hover:bg-gray-100 transition-all">
                    Batalkan
                </a>
            </div>
        </form>
    </div>
</div>
@endsection