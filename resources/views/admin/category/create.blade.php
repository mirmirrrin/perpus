@extends('layouts.admin')

@section('content')
<div class="w-full">
    <header class="mb-10 bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#c65c6a] flex justify-between items-center transition-all">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Tambah <span class="text-[#c65c6a]">Kategori</span></h2>
            <p class="text-sm text-gray-400 mt-1 font-bold uppercase tracking-widest ml-1">Tambah klasifikasi buku baru</p>
        </div>
        <a href="{{ route('admin.category.index') }}" class="bg-gray-50 text-[#c65c6a] px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#c65c6a] hover:text-white transition-all flex items-center gap-2 shadow-sm">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </header>

    <div class="max-w-2xl bg-white p-12 rounded-[3rem] shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-500">
        <form action="{{ route('admin.category.store') }}" method="POST" class="space-y-8">
            @csrf
            <div class="group">
                <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-4 tracking-[2px] ml-1">Nama Label Kategori</label>
                <div class="relative">
                    <input type="text" name="name" required placeholder="Contoh: SAINS, FILSAFAT, BIOGRAFI"
                        class="w-full px-8 py-5 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all shadow-sm placeholder:text-gray-300 uppercase tracking-wider">
                    <i class="fas fa-tag absolute right-8 top-6 text-gray-200"></i>
                </div>
                @error('name')
                <div class="mt-3 flex items-center gap-2 text-rose-500">
                    <i class="fas fa-exclamation-circle text-xs"></i>
                    <p class="text-[10px] font-bold uppercase tracking-wide">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button type="submit" class="flex-[2] bg-[#c65c6a] text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl shadow-[#c65c6a]/20 hover:bg-[#a34a56] transition-all active:scale-95">
                    Simpan Kategori
                </button>
                <a href="{{ route('admin.category.index') }}" class="flex-1 bg-gray-50 text-gray-400 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-center flex items-center justify-center hover:bg-gray-100 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection