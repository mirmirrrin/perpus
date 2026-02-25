@extends('layouts.siswa')
@section('title', 'Katalog Lengkap')

@section('content')
<header class="mb-12">
    <div class="inline-block px-4 py-1 rounded-full bg-[#fdf6f7] text-[#c65c6a] text-[10px] font-black uppercase tracking-[3px] mb-3 border border-[#c65c6a]/20">Explore Library</div>
    <h2 class="text-4xl font-black text-gray-800 tracking-tighter uppercase italic">Katalog <span class="text-[#c65c6a]">Buku</span></h2>
</header>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
    @foreach($books as $book)
    <div class="bg-white p-5 rounded-[2.5rem] border border-gray-50 shadow-sm hover:shadow-2xl transition-all duration-500 group">
        <div class="h-64 bg-[#fdf6f7] rounded-[2rem] mb-6 overflow-hidden flex items-center justify-center relative shadow-inner">
            @if($book->image)
            <img src="{{ asset('storage/' . $book->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            @else
            <i class="fas fa-book text-6xl text-[#c65c6a]/10"></i>
            @endif
            <div class="absolute bottom-4 left-4 bg-white/90 px-3 py-1 rounded-full text-[10px] font-black text-[#c65c6a] uppercase shadow-sm border border-[#c65c6a]/10 italic">
                {{ $book->category ?? 'General' }}
            </div>
        </div>
        <div class="px-2">
            <h3 class="font-black text-gray-800 text-lg leading-tight uppercase tracking-tight mb-1 truncate">{{ $book->title }}</h3>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[2px] mb-4 italic">{{ $book->author }}</p>
            <div class="flex items-center gap-2 text-[#c65c6a]">
                <i class="fas fa-check-circle text-xs"></i>
                <span class="text-[10px] font-black uppercase tracking-widest">Tersedia</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection