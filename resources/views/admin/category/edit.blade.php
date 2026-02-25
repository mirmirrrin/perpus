@extends('layouts.admin')

@section('content')
<div class="w-full">
    <header class="mb-10 bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#c65c6a] flex justify-between items-center transition-all">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Edit <span class="text-[#c65c6a]">Kategori</span></h2>
            <p class="text-sm text-gray-400 mt-1 font-bold uppercase tracking-widest ml-1">Perbarui label klasifikasi</p>
        </div>
        <a href="{{ route('admin.category.index') }}" class="bg-gray-50 text-[#c65c6a] px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#c65c6a] hover:text-white transition-all flex items-center gap-2 shadow-sm">
            <i class="fas fa-times text-xs"></i> Tutup
        </a>
    </header>

    <div class="max-w-2xl bg-white p-12 rounded-[3rem] shadow-xl border border-gray-100">
        <form action="{{ route('admin.category.update', $category->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="group">
                <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-4 tracking-[2px] ml-1 text-center">Update Nama Kategori</label>
                <div class="relative">
                    <input type="text" name="name" value="{{ $category->name }}" required
                        class="w-full px-8 py-6 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-black text-gray-700 transition-all shadow-inner text-center text-xl uppercase tracking-[0.1em]">
                    <div class="absolute inset-y-0 left-8 flex items-center pointer-events-none opacity-20">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="absolute inset-y-0 right-8 flex items-center pointer-events-none opacity-20">
                        <i class="fas fa-quote-right"></i>
                    </div>
                </div>
                @error('name')
                <p class="text-rose-500 text-[10px] mt-4 font-black uppercase tracking-widest text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit" class="flex-[2] bg-[#c65c6a] text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl shadow-[#c65c6a]/20 hover:bg-[#a34a56] transition-all active:scale-95">
                    Update Perubahan
                </button>
                <a href="{{ route('admin.category.index') }}" class="flex-1 bg-gray-50 text-gray-400 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-center flex items-center justify-center transition-all hover:bg-gray-100">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection