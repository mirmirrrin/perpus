@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-3xl mx-auto">
    <header class="mb-10 bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#c65c6a] flex justify-between items-center transition-all">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Edit <span class="text-[#c65c6a]">Kategori</span></h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1 italic">Perbarui label klasifikasi koleksi</p>
        </div>
        <a href="{{ route('admin.category.index') }}" class="w-12 h-12 bg-gray-50 text-gray-300 hover:bg-rose-500 hover:text-white rounded-2xl flex items-center justify-center transition-all shadow-sm">
            <i class="fas fa-times"></i>
        </a>
    </header>

    <div class="bg-white p-12 rounded-[3rem] shadow-xl border border-gray-100 relative">
        <div class="absolute top-0 left-0 w-full h-2 bg-[#c65c6a]"></div>

        <form action="{{ route('admin.category.update', $category->id) }}" method="POST" class="space-y-10 text-center">
            @csrf
            @method('PUT')

            <div class="group">
                <label class="block text-[10px] font-black uppercase text-[#c65c6a] mb-6 tracking-[4px]">Update Nama Kategori</label>
                <div class="relative max-w-lg mx-auto">
                    <input type="text" name="name" value="{{ $category->name }}" required
                        class="w-full px-8 py-6 bg-[#fcf7f8] rounded-2xl border-b-4 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-black text-gray-800 transition-all shadow-inner text-center text-2xl uppercase tracking-[0.2em]">
                </div>
                @error('name')
                <p class="text-rose-500 text-[10px] mt-6 font-black uppercase tracking-widest">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit" class="flex-[2] bg-[#c65c6a] text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl shadow-[#c65c6a]/20 hover:bg-gray-800 transition-all active:scale-95">
                    Update Perubahan
                </button>
                <a href="{{ route('admin.category.index') }}" class="flex-1 bg-gray-50 text-gray-400 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-center flex items-center justify-center hover:bg-gray-100">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection