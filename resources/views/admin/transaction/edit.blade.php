@extends('layouts.admin')

@section('content')
<div class="w-full">
    {{-- HEADER --}}
    <header class="mb-10 bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#c65c6a] flex justify-between items-center transition-all">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Update <span class="text-[#c65c6a]">Data Pinjaman</span></h2>
            <p class="text-sm text-gray-400 mt-1 font-bold uppercase tracking-widest ml-1">Nomor Transaksi: #TRX-{{ $transaction->id }}</p>
        </div>
        <a href="{{ route('admin.transaction.index') }}" class="w-12 h-12 bg-gray-50 text-gray-300 hover:bg-rose-500 hover:text-white rounded-2xl flex items-center justify-center transition-all shadow-sm active:scale-95">
            <i class="fas fa-times text-lg"></i>
        </a>
    </header>

    @if ($errors->any())
    <div class="max-w-4xl mb-8 p-5 bg-red-50 rounded-2xl border-l-8 border-red-500 text-red-700 animate-head-shake">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-xl"></i>
            <div>
                <p class="font-black text-xs uppercase tracking-widest">Validasi Gagal</p>
                <ul class="text-[11px] font-bold opacity-80 mt-1">
                    @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="max-w-4xl bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.transaction.update', $transaction->id) }}" method="POST" class="p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- INFO USER --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest ml-1">Data Siswa (Peminjam)</label>
                    <div class="w-full bg-gray-50 px-7 py-5 rounded-2xl border border-gray-100 font-bold text-gray-400 flex items-center gap-4 italic">
                        <i class="fas fa-user-shield text-[#c65c6a]/30"></i>
                        {{ $transaction->user->name ?? 'User Tidak Ditemukan' }}
                    </div>
                </div>

                {{-- INFO BUKU --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest ml-1">Koleksi Terpinjam</label>
                    <div class="w-full bg-gray-50 px-7 py-5 rounded-2xl border border-gray-100 font-bold text-gray-400 flex items-center gap-4 italic">
                        <i class="fas fa-book-lock text-[#c65c6a]/30"></i>
                        {{ $transaction->book->name ?? 'Buku Tidak Ditemukan' }}
                    </div>
                </div>

                {{-- TANGGAL PINJAM --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-widest ml-1">Ubah Tanggal Pinjam</label>
                    <input type="date" name="borrowed_at"
                        value="{{ old('borrowed_at', $transaction->borrowed_at ? $transaction->borrowed_at->format('Y-m-d') : '') }}"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white outline-none transition-all font-bold text-gray-700 shadow-sm">
                </div>

                {{-- TENGGAT KEMBALI --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-widest ml-1">Ubah Tenggat Kembali</label>
                    <input type="date" name="returned_at"
                        value="{{ old('returned_at', $transaction->returned_at ? $transaction->returned_at->format('Y-m-d') : '') }}"
                        class="w-full px-7 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white outline-none transition-all font-bold text-gray-700 shadow-sm border-b-4 border-rose-100">
                </div>

                {{-- STATUS TRANSAKSI --}}
                <div class="md:col-span-2 group">
                    <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-3 tracking-widest ml-1 text-center">Update Status Saat Ini</label>
                    <div class="relative">
                        <select name="status" class="w-full bg-[#fdf7f8] px-8 py-5 rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white outline-none transition-all font-black text-gray-700 appearance-none cursor-pointer text-center uppercase tracking-widest">
                            <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="borrowed" {{ $transaction->status == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                            <option value="returned" {{ $transaction->status == 'returned' ? 'selected' : '' }}>Returned</option>
                            <option value="rejected" {{ $transaction->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-8 top-6 text-[#c65c6a]"></i>
                    </div>
                    <div class="mt-4 p-4 bg-amber-50 rounded-2xl border-2 border-amber-100 flex items-start gap-3">
                        <i class="fas fa-info-circle text-amber-500 mt-1"></i>
                        <p class="text-[10px] text-amber-800 font-bold italic leading-relaxed">
                            PENTING: Pastikan fisik buku sudah diterima sebelum mengubah status menjadi "Returned". Stok buku akan bertambah secara otomatis oleh sistem.
                        </p>
                    </div>
                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-10">
                <button type="submit" class="flex-[2] bg-[#c65c6a] hover:bg-[#a34a56] text-white font-black uppercase tracking-[0.2em] py-5 rounded-2xl shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95">
                    <i class="fas fa-save mr-2"></i> Update Transaksi
                </button>
                <a href="{{ route('admin.transaction.index') }}" class="flex-1 py-5 bg-gray-50 text-gray-400 font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-gray-100 transition-all text-center flex items-center justify-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection