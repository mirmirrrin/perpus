@extends('layouts.admin')

@section('title', 'Update Transaksi')

@section('content')
<div class="max-w-4xl mx-auto">
    <header class="mb-10 bg-white p-8 rounded-[2rem] shadow-sm border-b-4 border-[#c65c6a] flex justify-between items-center transition-all">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Update <span class="text-[#c65c6a]">Transaksi</span></h2>
            <p class="text-[10px] text-gray-400 mt-1 font-bold uppercase tracking-widest ml-1">TRX-ID: #{{ $transaction->id }}</p>
        </div>
        <a href="{{ route('admin.transaction.index') }}" class="w-12 h-12 bg-gray-50 text-gray-300 hover:bg-[#c65c6a] hover:text-white rounded-2xl flex items-center justify-center transition-all">
            <i class="fas fa-times"></i>
        </a>
    </header>

    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-50 overflow-hidden">
        <div class="w-full h-2 bg-[#c65c6a]"></div>
        <form action="{{ route('admin.transaction.update', $transaction->id) }}" method="POST" class="p-10 space-y-8">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Readonly Infos --}}
                <div class="space-y-2 opacity-60">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Siswa</label>
                    <div class="w-full bg-gray-50 px-7 py-4 rounded-2xl font-bold text-gray-500 italic text-sm">{{ $transaction->user->name ?? '-' }}</div>
                </div>
                <div class="space-y-2 opacity-60">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Buku</label>
                    <div class="w-full bg-gray-50 px-7 py-4 rounded-2xl font-bold text-gray-500 italic text-sm">{{ Str::limit($transaction->book->name ?? '-', 30) }}</div>
                </div>

                {{-- Editable Dates --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Edit Tgl Pinjam</label>
                    <input type="date" name="borrowed_at" value="{{ $transaction->borrowed_at->format('Y-m-d') }}"
                        class="w-full px-7 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] font-bold text-gray-700 transition-all shadow-sm">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1">Edit Tenggat</label>
                    <input type="date" name="returned_at" value="{{ $transaction->returned_at->format('Y-m-d') }}"
                        class="w-full px-7 py-4 bg-[#fcf7f8] rounded-2xl border-2 border-transparent focus:border-[#c65c6a] font-bold text-gray-700 transition-all shadow-sm">
                </div>

                {{-- Status --}}
                <div class="md:col-span-2 space-y-4">
                    <label class="text-[10px] font-black uppercase text-[#c65c6a] tracking-widest ml-1 text-center block">Status Transaksi</label>
                    <select name="status" class="w-full bg-[#fdf7f8] px-8 py-5 rounded-[2rem] border-2 border-transparent focus:border-[#c65c6a] font-black text-gray-700 appearance-none text-center uppercase tracking-widest cursor-pointer">
                        <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="borrowed" {{ $transaction->status == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                        <option value="returned" {{ $transaction->status == 'returned' ? 'selected' : '' }}>Returned</option>
                        <option value="rejected" {{ $transaction->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#c65c6a] hover:bg-gray-800 text-white py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] shadow-xl shadow-[#c65c6a]/20 transition-all active:scale-95">
                <i class="fas fa-save mr-2"></i> Update Transaksi
            </button>
        </form>
    </div>
</div>
@endsection