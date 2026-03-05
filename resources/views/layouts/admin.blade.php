<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fdfafb;
        }

        .bg-sidebar {
            background: linear-gradient(180deg, #2d131a 0%, #3a1620 30%, #7a3b4b 100%);
        }

        .menu-active {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            border-left: 6px solid #f1c6cf;
            color: #fff !important;
            font-weight: 800;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d8a3b0;
            border-radius: 10px;
        }

        .fade-in {
            animation: fadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-gray-800">

    {{-- Sidebar --}}
    <aside class="w-80 bg-sidebar text-white hidden md:flex flex-col shadow-[10px_0_30px_rgba(0,0,0,0.1)] shrink-0 z-50 h-full">
        <div class="p-10 border-b border-white/5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center border border-white/20">
                    <i class="fas fa-book-open text-[#f1c6cf] text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-black tracking-tighter uppercase italic">Admin<span class="text-[#f1c6cf]"> Lyi</span></h1>
                    <p class="text-[9px] text-white/40 uppercase tracking-[0.3em] font-bold italic">admin pages</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-6 py-10 space-y-2 overflow-y-auto custom-scrollbar">
            @php
            $menuClass = 'flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 group';
            $hover = 'text-white/50 hover:text-white hover:bg-white/5';
            @endphp

            <a href="{{ route('admin.dashboard') }}" class="{{ $menuClass }} {{ Request::is('admin/dashboard') ? 'menu-active' : $hover }}">
                <i class="fas fa-th-large w-5 group-hover:rotate-6 transition-transform"></i>
                <span class="text-xs uppercase font-black tracking-widest">Dashboard</span>
            </a>

            <a href="{{ route('admin.category.index') }}" class="{{ $menuClass }} {{ Request::is('admin/category*') ? 'menu-active' : $hover }}">
                <i class="fas fa-tags w-5 group-hover:rotate-6 transition-transform"></i>
                <span class="text-xs uppercase font-black tracking-widest">Kategori Buku</span>
            </a>

            <a href="{{ route('admin.book.index') }}" class="{{ $menuClass }} {{ Request::is('admin/book*') ? 'menu-active' : $hover }}">
                <i class="fas fa-book-open w-5 group-hover:rotate-6 transition-transform"></i>
                <span class="text-xs uppercase font-black tracking-widest">Kelola Buku</span>
            </a>

            <a href="{{ route('admin.student.index') }}" class="{{ $menuClass }} {{ Request::is('admin/student*') ? 'menu-active' : $hover }}">
                <i class="fas fa-users w-5 group-hover:rotate-6 transition-transform"></i>
                <span class="text-xs uppercase font-black tracking-widest">Kelola Siswa</span>
            </a>

            <a href="{{ route('admin.transaction.index') }}" class="{{ $menuClass }} {{ Request::is('admin/transaction*') ? 'menu-active' : $hover }}">
                <i class="fas fa-exchange-alt w-5 group-hover:rotate-6 transition-transform"></i>
                <span class="text-xs uppercase font-black tracking-widest">Log Transaksi</span>
            </a>
        </nav>

        <div class="p-8 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center justify-center gap-3 py-4 rounded-[1.5rem] bg-rose-500/10 hover:bg-rose-500 text-rose-300 hover:text-white font-black transition-all duration-500 group">
                    <i class="fas fa-power-off text-xs group-hover:rotate-90 transition-transform"></i>
                    <span class="text-[10px] uppercase tracking-[0.2em]">Logout Session</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Wrapper --}}
    <div class="flex-1 flex flex-col h-full overflow-hidden">

        {{-- Header --}}
        <header class="bg-white/70 backdrop-blur-xl shrink-0 z-40 px-10 py-6 border-b border-gray-50 flex items-center justify-between">
            <h2 class="text-sm font-black text-gray-400 uppercase tracking-[0.4em]">
                System / <span class="text-gray-800">@yield('title')</span>
            </h2>

            <div class="flex items-center gap-5 bg-gray-50 px-4 py-2 rounded-2xl border border-gray-100">
                <div class="text-right">
                    <p class="text-[10px] font-black text-gray-800 uppercase italic">Admin</p>
                    <p class="text-[8px] font-bold text-[#c65c6a] uppercase tracking-widest">Online</p>
                </div>
                <img src="https://ui-avatars.com/api/?name=Admin&background=7a3b4b&color=fff" class="w-10 h-10 rounded-xl shadow-lg shadow-[#7a3b4b]/20">
            </div>
        </header>

        {{-- Scrollable Content --}}
        <main class="flex-1 overflow-y-auto custom-scrollbar bg-[#fdfafb] p-12">
            <div class="fade-in max-w-7xl mx-auto pb-20">
                {{-- Alert Messages --}}
                @if(session('success'))
                <div class="mb-8 p-5 bg-emerald-50 border-l-8 border-emerald-500 rounded-[2rem] flex items-center gap-4 shadow-sm">
                    <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center shadow-lg shadow-emerald-200">
                        <i class="fas fa-check text-xs"></i>
                    </div>
                    <p class="text-emerald-800 font-black text-[10px] uppercase tracking-widest">{{ session('success') }}</p>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-8 p-5 bg-rose-50 border-l-8 border-rose-500 rounded-[2rem] flex items-center gap-4 shadow-sm">
                    <div class="w-10 h-10 bg-rose-500 text-white rounded-full flex items-center justify-center shadow-lg shadow-rose-200">
                        <i class="fas fa-times text-xs"></i>
                    </div>
                    <p class="text-rose-800 font-black text-[10px] uppercase tracking-widest">{{ session('error') }}</p>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>