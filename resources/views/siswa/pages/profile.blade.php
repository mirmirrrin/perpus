@extends('layouts.siswa')
@section('title', 'Profile Saya')

@section('content')
{{-- Style tambahan untuk Gradient & Animasi --}}
<style>
    .maroon-gradient {
        background: linear-gradient(135deg, #743544 0%, #c65c6a 100%);
    }
</style>

<div class="max-w-4xl mx-auto" x-data="{ tab: 'profile' }">
    {{-- Header --}}
    <header class="mb-8">
        <h2 class="text-3xl font-black text-gray-800 tracking-tighter uppercase italic">Profile <span class="text-[#c65c6a]">Saya</span></h2>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1 mt-1">Kelola informasi akun dan keamanan anda</p>
    </header>

    {{-- Main Card --}}
    <div class="bg-white rounded-[3rem] shadow-xl shadow-gray-200/50 border border-gray-50 overflow-hidden">
        <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Cover & Profile Photo --}}
            <div class="relative h-48 maroon-gradient">
                <div class="absolute -bottom-12 left-12 flex items-end gap-6">
                    <div class="relative group">
                        @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" class="w-32 h-32 rounded-full border-4 border-white shadow-xl object-cover bg-white">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=fff&color=c65c6a&size=128" class="w-32 h-32 rounded-full border-4 border-white shadow-xl object-cover bg-white">
                        @endif

                        <label class="absolute bottom-0 right-0 bg-[#c65c6a] text-white w-10 h-10 rounded-full border-2 border-white flex items-center justify-center cursor-pointer hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-camera text-xs"></i>
                            <input type="file" name="avatar" id="avatarInput" class="hidden">
                        </label>
                    </div>
                </div>
            </div>

            {{-- Tabs Navigation --}}
            <div class="mt-16 px-12 border-b border-gray-100 flex gap-8">
                <button type="button" @click="tab = 'profile'"
                    :class="tab === 'profile' ? 'border-[#c65c6a] text-[#c65c6a]' : 'border-transparent text-gray-400'"
                    class="pb-4 border-b-2 font-black uppercase text-[10px] tracking-[0.2em] transition-all">
                    Informasi Profil
                </button>
                <button type="button" @click="tab = 'password'"
                    :class="tab === 'password' ? 'border-[#c65c6a] text-[#c65c6a]' : 'border-transparent text-gray-400'"
                    class="pb-4 border-b-2 font-black uppercase text-[10px] tracking-[0.2em] transition-all">
                    Keamanan Password
                </button>
            </div>

            <div class="p-12">
                {{-- Tab Profile --}}
                <div x-show="tab === 'profile'" x-transition class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="0812..." class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Username</label>
                            <input type="text" name="username" value="{{ Auth::user()->username }}" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-rose-300 ml-2">Email (ID Login)</label>
                            <input type="text" value="{{ Auth::user()->email }}" readonly class="w-full px-6 py-4 rounded-2xl bg-gray-100 border-none font-bold text-gray-400 cursor-not-allowed">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold text-gray-700 transition-all resize-none">{{ Auth::user()->alamat }}</textarea>
                    </div>

                    <button type="submit" class="maroon-gradient text-white px-10 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-[#c65c6a]/30 active:scale-95 transition-all">
                        Simpan Perubahan
                    </button>
                </div>

                {{-- Tab Password --}}
                <div x-show="tab === 'password'" x-transition style="display:none">
                    <div class="max-w-md space-y-6">
                        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 flex gap-4 items-center">
                            <i class="fas fa-shield-alt text-amber-500"></i>
                            <p class="text-[10px] font-bold text-amber-700 uppercase leading-relaxed">Kosongkan jika tidak ingin mengganti password</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Password Baru</label>
                            <input type="password" name="password" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-[#c65c6a] focus:bg-white focus:outline-none font-bold transition-all">
                        </div>
                        <button type="submit" class="maroon-gradient text-white px-10 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-[#c65c6a]/30 active:scale-95 transition-all">
                            Update Keamanan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- TOMBOL KEMBALI DI BAWAH CARD --}}
    <div class="mt-10 flex justify-center">
        <a href="{{ route('siswa.dashboard') }}" class="group flex items-center gap-3 text-gray-400 hover:text-[#c65c6a] transition-all duration-300">
            <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center group-hover:bg-[#fdf2f3] transition-colors">
                <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
            </div>
            <span class="font-black uppercase text-[10px] tracking-[0.3em]">Kembali ke Beranda</span>
        </a>
    </div>
</div>

{{-- Alpine JS --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection