@extends('layouts.siswa')
@section('title', 'Katalog Lengkap')

@section('content')
<div class="max-w-7xl mx-auto">
    <header class="mb-12">
        <div class="inline-block px-4 py-1 rounded-full bg-[#fdf2f3] text-[#c65c6a] text-[10px] font-black uppercase tracking-[3px] mb-4 border border-[#c65c6a]/20">Discovery</div>
        <h2 class="text-5xl font-black text-gray-800 tracking-tighter uppercase italic">KATALOG <span class="text-[#c65c6a]">LENGKAP</span></h2>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($books as $book)
        <div class="bg-white p-5 rounded-[3rem] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-700 group">
            <div class="h-80 bg-[#fdf6f7] rounded-[2.5rem] mb-6 overflow-hidden relative shadow-inner">
                @if($book->image)
                <img src="{{ asset('storage/' . $book->image) }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center bg-gray-50">
                    <i class="fas fa-book text-6xl text-[#c65c6a]/10"></i>
                </div>
                @endif

                {{-- Overlap Info --}}
                <div class="absolute bottom-5 left-5 right-5">
                    <div class="bg-white/95 backdrop-blur-sm p-4 rounded-2xl shadow-xl border border-white">
                        <p class="text-[7px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Penerbit</p>
                        <p class="text-[10px] font-black text-gray-800 uppercase truncate">{{ $book->publisher ?? 'Gramedia Pustaka' }}</p>
                    </div>
                </div>
            </div>

            <div class="px-3">
                <p class="text-[9px] font-black text-[#c65c6a] uppercase tracking-widest mb-1">{{ $book->category->name ?? 'Literasi' }}</p>
                <h3 class="font-black text-gray-800 text-lg leading-tight uppercase tracking-tighter mb-3 truncate italic">{{ $book->name }}</h3>

                <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-user text-[8px] text-gray-400"></i>
                        </div>
                        <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">{{ Str::limit($book->author, 12) }}</p>
                    </div>
                    <span class="text-[8px] bg-emerald-50 text-emerald-600 px-2 py-1 rounded-md font-black uppercase italic">Tersedia</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection