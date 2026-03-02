<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PerpusGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .maroon-gradient { background: linear-gradient(135deg, #4a1d28 0%, #743544 50%, #c65c6a 100%); }
        .sidebar-active {
            background: #fff !important;
            color: #743544 !important;
            font-weight: 800;
            transform: translateX(5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        /* Custom Scrollbar */
        main::-webkit-scrollbar { width: 6px; }
        main::-webkit-scrollbar-thumb { background: #c65c6a; border-radius: 10px; }
        
        @keyframes bounce-short {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-bounce-short { animation: bounce-short 2s ease-in-out infinite; }
    </style>
</head>

<body class="bg-[#fcf7f8] flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-80 maroon-gradient text-white shrink-0 flex flex-col shadow-[15px_0_40px_rgba(116,53,68,0.15)] h-full z-50">
        <div class="p-12 text-center border-b border-white/5">
            <h1 class="text-2xl font-black uppercase tracking-[0.2em] italic">Perpus<span class="opacity-40">LYI</span></h1>
            <p class="text-[8px] font-bold uppercase tracking-[0.5em] mt-2 opacity-50 text-[#f1c6cf]">Student Member</p>
        </div>

        <nav class="mt-12 flex-1 px-8 space-y-4">
            @php $itemClass = "flex items-center py-5 px-8 rounded-[2rem] transition-all duration-500 group uppercase text-[10px] font-black tracking-widest"; @endphp

            <a href="{{ route('siswa.dashboard') }}" class="{{ $itemClass }} {{ request()->routeIs('siswa.dashboard') ? 'sidebar-active' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <i class="fas fa-home mr-4 group-hover:scale-125 transition-transform"></i> Dashboard
            </a>

            <a href="{{ route('siswa.borrow') }}" class="{{ $itemClass }} {{ request()->routeIs('siswa.borrow') ? 'sidebar-active' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <i class="fas fa-book mr-4 group-hover:scale-125 transition-transform"></i> Peminjaman Buku
            </a>

            <a href="{{ route('siswa.return') }}" class="{{ $itemClass }} {{ request()->routeIs('siswa.return') ? 'sidebar-active' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <i class="fas fa-history mr-4 group-hover:scale-125 transition-transform"></i> Pengembalian Buku
            </a>
        </nav>

        <div class="p-10 border-t border-white/5">
            <div class="flex items-center gap-4 mb-8 bg-black/20 p-5 rounded-[2rem] border border-white/5">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=c65c6a&color=fff" class="w-10 h-10 rounded-2xl shadow-lg">
                <div class="truncate">
                    <p class="text-[8px] font-black uppercase opacity-40 tracking-widest italic">Account</p>
                    <p class="text-xs font-black truncate tracking-tight">{{ Auth::user()->name }}</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full bg-rose-500/20 hover:bg-rose-500 py-5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-500 flex items-center justify-center gap-3">
                    <i class="fas fa-sign-out-alt"></i> Keluar Aplikasi
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Area --}}
    <main class="flex-1 h-full overflow-y-auto p-14 bg-[#fcf7f8]">
        <div class="max-w-7xl mx-auto pb-24">
            
            {{-- OTOMATIS MUNCUL JIKA ADA SUCCESS --}}
            @if(session('success'))
            <div class="mb-10 p-5 bg-emerald-500 text-white rounded-[2rem] shadow-xl shadow-emerald-500/20 flex items-center gap-4 animate-bounce-short">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-sm"></i>
                </div>
                <p class="font-black uppercase text-[10px] tracking-widest">{{ session('success') }}</p>
            </div>
            @endif

            {{-- OTOMATIS MUNCUL JIKA ADA ERROR --}}
            @if(session('error'))
            <div class="mb-10 p-5 bg-rose-500 text-white rounded-[2rem] shadow-xl shadow-rose-500/20 flex items-center gap-4 animate-bounce-short">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-sm"></i>
                </div>
                <p class="font-black uppercase text-[10px] tracking-widest">{{ session('error') }}</p>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>