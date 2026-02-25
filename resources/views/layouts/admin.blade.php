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
        }

        .bg-sidebar {
            background: linear-gradient(180deg, #3a1620 0%, #7a3b4b 100%);
        }

        .menu-active {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.18), transparent);
            border-left: 4px solid #f1c6cf;
            color: #fff !important;
            font-weight: 700;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d8a3b0;
            border-radius: 10px;
        }

        .fade-in {
            animation: fadeIn .5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-[#fcfafb] min-h-screen flex overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-sidebar text-white hidden md:flex flex-col shadow-2xl shrink-0">

        <!-- LOGO -->
        <div class="p-8 border-b border-white/10">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-white/20 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-book-open text-[#f1c6cf] text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-extrabold tracking-tight">
                        <span class="text-[#f1c6cf]">Admin</span>
                    </h1>
                    <p class="text-[10px] text-white/50 uppercase tracking-widest font-semibold">
                        Library System
                    </p>
                </div>
            </div>
        </div>

        <!-- MENU -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
            <p class="px-4 text-[10px] font-bold text-white/40 uppercase tracking-widest mb-4">
                Menu Utama
            </p>

            @php
            $menuClass = 'flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300';
            $hover = 'text-white/60 hover:text-white hover:bg-white/5';
            @endphp

            <a href="{{ route('admin.dashboard') }}" class="{{ $menuClass }} {{ Request::is('admin/dashboard') ? 'menu-active' : $hover }}">
                <i class="fas fa-chart-pie w-5"></i>
                <span class="text-sm">Dashboard</span>
            </a>

            <a href="{{ route('admin.book.index') }}" class="{{ $menuClass }} {{ Request::is('admin/book*') ? 'menu-active' : $hover }}">
                <i class="fas fa-book-open w-5 text-[#f1c6cf]"></i>
                <span class="text-sm">Kelola Buku</span>
            </a>

            <a href="{{ route('admin.student.index') }}" class="{{ $menuClass }} {{ Request::is('admin/student*') ? 'menu-active' : $hover }}">
                <i class="fas fa-user-graduate w-5"></i>
                <span class="text-sm">Kelola Siswa</span>
            </a>

            <a href="{{ route('admin.transaction.index') }}" class="{{ $menuClass }} {{ Request::is('admin/transaction*') ? 'menu-active' : $hover }}">
                <i class="fas fa-arrow-right-arrow-left w-5"></i>
                <span class="text-sm">Transaksi</span>
            </a>

            <a href="{{ route('admin.category.index') }}" class="{{ $menuClass }} {{ Request::is('admin/category*') ? 'menu-active' : $hover }}">
                <i class="fas fa-layer-group w-5"></i>
                <span class="text-sm">Kategori Buku</span>
            </a>
        </nav>

        <!-- LOGOUT -->
        <div class="p-6 border-t border-white/10">
            <form action="/logout" method="POST">
                @csrf
                <button class="w-full flex items-center justify-center gap-3 py-4 rounded-2xl
                    bg-white/10 hover:bg-red-500/20
                    text-white/80 hover:text-red-300
                    font-bold transition-all duration-300 group">
                    <i class="fas fa-power-off group-hover:rotate-90 transition-transform"></i>
                    <span class="text-xs uppercase tracking-widest">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- HEADER -->
        <header class="bg-white/90 backdrop-blur sticky top-0 z-30 border-b border-gray-100">
            <div class="flex items-center justify-between px-10 py-4">
                <h2 class="text-xl font-extrabold text-[#2d1a1e]">
                    @yield('page_title', 'Dashboard')
                </h2>

                <div class="flex items-center gap-6">
                    <!-- <button class="relative text-gray-400 hover:text-[#7a3b4b] transition">
                        <i class="far fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] flex items-center justify-center rounded-full border-2 border-white">3</span>
                    </button> -->

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] text-gray-400 uppercase font-semibold">Admin</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Admin&background=7a3b4b&color=fff"
                            class="w-10 h-10 rounded-xl border-2 border-[#f1c6cf]/40 shadow-md">
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN -->
        <main class="flex-1 p-10 overflow-y-auto custom-scrollbar fade-in">

            {{-- Alert Sukses (Hijau) --}}
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 rounded-xl flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500"></i>
                <p class="text-green-700 font-bold text-sm">{{ session('success') }}</p>
            </div>
            @endif

            {{-- Alert Hapus/Error (Merah) --}}
            @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-xl flex items-center gap-3">
                <i class="fas fa-trash-alt text-red-500"></i>
                <p class="text-red-700 font-bold text-sm">{{ session('error') }}</p>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>

</html>