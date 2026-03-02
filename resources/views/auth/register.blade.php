<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-gradient-custom {
            background: linear-gradient(135deg, #7a3b4b 0%, #9a5566 100%);
        }

        /* Animasi halus untuk error */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-[#f8f4f5] min-h-screen flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-4xl rounded-[40px] shadow-[0_20px_50px_rgba(122,59,75,0.2)] overflow-hidden flex flex-col md:flex-row min-h-[600px]">

        <div class="md:w-5/12 bg-gradient-custom flex flex-col items-center py-12 text-white">
            <div class="mb-20 text-center px-6">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 mx-auto border border-white/30">
                    <i class="fas fa-user-plus text-3xl text-[#f1c6cf]"></i>
                </div>
                <h2 class="text-xl font-black tracking-widest uppercase italic">Perpus Digital</h2>
            </div>

        </div>

        <div class="md:w-7/12 p-10 md:p-14 flex flex-col justify-center bg-white">
            <div class="text-center mb-8">
                <div class="inline-block px-4 py-1 rounded-full bg-[#f8f4f5] text-[#7a3b4b] text-[10px] font-bold uppercase tracking-[3px] mb-2 border border-[#d18c9c]/40">
                    Create Account
                </div>
                <h3 class="text-3xl font-black tracking-tighter text-[#7a3b4b]">SIGN UP</h3>
            </div>

            @if ($errors->any())
            <div class="mb-6 fade-in">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                    <ul class="list-none">
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600 text-xs font-bold uppercase tracking-tight">
                            <i class="fas fa-circle text-[6px] mr-2 align-middle"></i>{{ $error }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form action="/register" method="POST" class="space-y-4">
                @csrf
                <div class="group space-y-2">
                    <label class="text-[10px] font-bold text-[#7a3b4b] uppercase tracking-widest ml-1">Username</label>
                    <div class="flex items-center bg-gray-50 rounded-2xl px-5 py-4 border-2 border-gray-50 transition-all duration-300 input-focus-effect">
                        <i class="far fa-user text-gray-400 group-focus-within:text-[#7a3b4b] mr-4"></i>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="username"
                            class="bg-transparent w-full focus:outline-none text-gray-700 font-semibold placeholder:text-gray-300" required>
                    </div>
                </div>

                <div class="group space-y-2">
                    <label class="text-[10px] font-bold text-[#7a3b4b] uppercase tracking-widest ml-1">Email Address</label>
                    <div class="flex items-center bg-gray-50 rounded-2xl px-5 py-4 border-2 border-gray-50 transition-all duration-300 input-focus-effect">
                        <i class="far fa-envelope text-gray-400 group-focus-within:text-[#7a3b4b] mr-4"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                            class="bg-transparent w-full focus:outline-none text-gray-700 font-semibold placeholder:text-gray-300" required>
                    </div>
                </div>

                <div class="group space-y-2">
                    <label class="text-[10px] font-bold text-[#7a3b4b] uppercase tracking-widest ml-1">Nomor Telepon</label>
                    <div class="flex items-center bg-gray-50 rounded-2xl px-5 py-4 border-2 border-gray-50 transition-all duration-300 input-focus-effect">
                        <i class="fas fa-mobile-alt text-gray-400 group-focus-within:text-[#7a3b4b] mr-4"></i>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08123456789"
                            class="bg-transparent w-full focus:outline-none text-gray-700 font-semibold placeholder:text-gray-300" required>
                    </div>
                </div>

                <div class="group space-y-2">
                    <label class="text-[10px] font-bold text-[#7a3b4b] uppercase tracking-widest ml-1">Password</label>
                    <div class="relative flex items-center bg-gray-50 rounded-2xl px-5 py-4 border-2 border-gray-50 transition-all duration-300 input-focus-effect">
                        <i class="fas fa-lock text-gray-400 group-focus-within:text-[#7a3b4b] mr-4"></i>
                        <input type="password" name="password" id="reg-pass" placeholder="••••••••"
                            class="bg-transparent w-full focus:outline-none text-gray-700 font-semibold placeholder:text-gray-300" required>
                        <button type="button" onclick="togglePass('reg-pass', 'eye-reg')" class="text-gray-300 hover:text-[#7a3b4b] transition-colors">
                            <i id="eye-reg" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-6 space-y-6">
                    <button type="submit"
                        class="w-full bg-[#7a3b4b] hover:bg-[#5d2d39] text-white py-5 rounded-2xl font-bold text-sm shadow-[0_20px_40px_-12px_rgba(122,59,75,0.4)] transition-all transform active:scale-[0.98] uppercase tracking-widest">
                        DAFTAR SEKARANG
                    </button>

                    <div class="relative flex items-center justify-center py-2">
                        <div class="flex-grow border-t border-gray-100"></div>
                        <span class="flex-shrink mx-4 text-gray-300 text-[10px] font-bold uppercase tracking-widest">Atau</span>
                        <div class="flex-grow border-t border-gray-100"></div>
                    </div>

                    <p class="text-center text-sm text-gray-500 font-medium">
                        Sudah punya akun?
                        <a href="/login" class="text-[#7a3b4b] font-bold hover:underline decoration-2 underline-offset-4">Masuk Kembali</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePass(id, eyeId) {
            const input = document.getElementById(id);
            const eye = document.getElementById(eyeId);
            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                eye.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>

</html>