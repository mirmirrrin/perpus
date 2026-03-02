@extends('layouts.admin')

@section('title', 'Tambah Kategori Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header Section --}}
    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm mb-10 border-b-8 border-[#c65c6a] flex flex-col md:flex-row justify-between items-center gap-6 transition-all">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-10 h-[3px] bg-[#c65c6a] rounded-full"></span>
                <p class="text-[10px] font-black text-[#c65c6a] uppercase tracking-[0.3em]">Master Klasifikasi</p>
            </div>
            <h2 class="text-4xl font-black text-gray-800 tracking-tighter uppercase italic">Tambah <span class="text-[#c65c6a]">Kategori</span></h2>
        </div>

        <a href="{{ route('admin.category.index') }}" class="bg-gray-50 text-gray-400 px-8 py-3 rounded-2xl font-black text-[10px] hover:bg-gray-800 hover:text-white transition-all uppercase tracking-widest shadow-sm flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[3rem] shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] border border-gray-100 p-12 relative overflow-hidden">
        {{-- Dekorasi Sudut --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-[#fcf7f8] rounded-bl-[5rem] -z-0"></div>

        <form action="{{ route('admin.category.store') }}" method="POST" class="relative z-10 space-y-10">
            @csrf

            <div class="space-y-4">
                <label class="block text-[11px] font-black uppercase text-gray-400 mb-2 tracking-[0.3em] ml-2">
                    Nama Label Kategori <span class="text-[#c65c6a]">*</span>
                </label>

                <div class="relative group">
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#c65c6a] transition-colors">
                        <i class="fas fa-tag text-xl"></i>
                    </div>

                    <input type="text" name="name" required autofocus
                        placeholder="MISAL: SAINS, FILSAFAT, TEKNOLOGI"
                        value="{{ old('name') }}"
                        class="w-full pl-16 pr-8 py-6 bg-[#fcf7f8] rounded-[2rem] border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-black text-gray-700 transition-all shadow-inner text-lg uppercase tracking-widest placeholder:text-gray-200">
                </div>

                @error('name')
                <div class="flex items-center gap-2 mt-3 ml-4 text-rose-500">
                    <i class="fas fa-exclamation-circle text-xs"></i>
                    <p class="text-[10px] font-bold uppercase tracking-widest">{{ $message }}</p>
                </div>
                @enderror
            </div>

            {{-- Info Box Kecil --}}
            <div class="bg-amber-50/50 border border-amber-100 rounded-2xl p-6 flex items-start gap-4">
                <div class="text-amber-500 mt-1"><i class="fas fa-info-circle"></i></div>
                <p class="text-[10px] text-amber-700 font-bold uppercase tracking-tight leading-relaxed">
                    Pastikan nama kategori belum pernah terdaftar sebelumnya. Gunakan nama yang singkat dan padat untuk memudahkan pencarian di rak buku.
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit" class="flex-[2] bg-[#c65c6a] hover:bg-gray-800 text-white py-6 rounded-[2rem] font-black uppercase tracking-[0.3em] shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                    <i class="fas fa-save text-lg"></i>
                    Simpan Kategori
                </button>

                <a href="{{ route('admin.category.index') }}" class="flex-1 bg-gray-50 text-gray-400 py-6 rounded-[2rem] font-black uppercase tracking-[0.3em] text-center flex items-center justify-center hover:bg-gray-100 transition-all">
                    Batalkan
                </a>
            </div>
        </form>
    </div>
</div>
@endsection