<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PerpusGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .maroon-gradient {
            background: linear-gradient(135deg, #743544 0%, #c65c6a 100%);
        }
    </style>
</head>

<body class="bg-[#fdf6f7] flex min-h-screen">
    <aside class="w-72 maroon-gradient text-white flex-shrink-0 flex flex-col shadow-2xl sticky top-0 h-screen">
        <div class="p-8 text-center border-b border-white/10">
            <h1 class="text-xl font-black uppercase tracking-widest">Perpus Digital</h1>
        </div>

        <nav class="mt-10 flex-1 px-6 space-y-3">
            <a href="{{ route('siswa.dashboard') }}"
                class="flex items-center py-4 px-6 rounded-2xl transition-all {{ request()->routeIs('siswa.dashboard') ? 'bg-white text-[#743544] shadow-lg font-bold' : 'text-white/70 hover:bg-white/10' }}">
                <i class="fas fa-th-large mr-3"></i> Dashboard
            </a>
            <a href="{{ route('siswa.borrow') }}"
                class="flex items-center py-4 px-6 rounded-2xl transition-all {{ request()->routeIs('siswa.borrow') ? 'bg-white text-[#743544] shadow-lg font-bold' : 'text-white/70 hover:bg-white/10' }}">
                <i class="fas fa-book-open mr-3"></i> Pinjam Buku
            </a>
            <a href="{{ route('siswa.return') }}"
                class="flex items-center py-4 px-6 rounded-2xl transition-all {{ request()->routeIs('siswa.return') ? 'bg-white text-[#743544] shadow-lg font-bold' : 'text-white/70 hover:bg-white/10' }}">
                <i class="fas fa-exchange-alt mr-3"></i> Pengembalian Buku
            </a>
        </nav>

        <div class="p-8 border-t border-white/10">
            <div class="flex items-center gap-3 mb-6">
                <div class="truncate">
                    <p class="text-xs font-black uppercase opacity-60">Siswa Aktif</p>
                    <p class="text-sm font-bold">{{ Auth::user()->name }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full bg-white/10 hover:bg-white/20 py-3 rounded-xl text-xs font-black uppercase">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">
        @yield('content')
    </main>
</body>

</html>