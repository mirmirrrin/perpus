<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-gradient-custom {
            background: linear-gradient(135deg, #7a3b4b 0%, #9a5566 100%);
        }
    </style>
</head>

<body class="bg-[#f8f4f5] min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-4xl rounded-[40px] shadow-[0_20px_50px_rgba(122,59,75,0.25)] overflow-hidden flex flex-col md:flex-row min-h-[600px]">
        <div class="md:w-5/12 bg-gradient-custom relative flex flex-col items-center py-12 text-white">
            <div class="mb-20 text-center px-6">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 mx-auto border border-white/30">
                    <i class="fas fa-book-reader text-3xl text-[#f1c6cf]"></i>
                </div>
                <h2 class="text-xl font-black tracking-widest uppercase italic">Perpus Digital</h2>
            </div>
        </div>

        <div class="md:w-7/12 p-10 md:p-16 flex flex-col justify-center bg-white">
            <div class="text-center mb-10">
                <div class="inline-block px-4 py-1 rounded-full bg-[#f8f4f5] text-[#7a3b4b] text-[10px] font-bold uppercase tracking-[3px] mb-2 border border-[#d18c9c]/40">
                    Welcome Back
                </div>
                <h3 class="text-3xl font-black tracking-tighter text-[#7a3b4b]">LOGIN</h3>

                @if(session()->has('loginError'))
                <p class="text-red-500 text-xs font-bold mt-2">{{ session('loginError') }}</p>
                @endif
            </div>

            <form action="/login" method="POST" class="space-y-6">
                @csrf

                <div class="group space-y-2">
                    <label class="text-xs font-bold text-[#7a3b4b] uppercase tracking-widest ml-1">Username / Email</label>
                    <div class="flex items-center bg-gray-50 rounded-2xl px-5 py-4 border-2 border-gray-50 focus-within:border-[#7a3b4b]/20 focus-within:bg-white transition-all duration-300 input-focus-effect">
                        <i class="far fa-envelope text-gray-400 group-focus-within:text-[#7a3b4b] mr-4 transition-colors"></i>
                        <input type="text" name="login" placeholder="Contoh: nama@gmail.com"
                            class="bg-transparent w-full focus:outline-none text-gray-700 font-semibold placeholder:text-gray-300" required>
                    </div>
                </div>

                <div class="group space-y-2">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-xs font-bold text-[#7a3b4b] uppercase tracking-widest">Password</label>
                    </div>
                    <div class="relative flex items-center bg-gray-50 rounded-2xl px-5 py-4 border-2 border-gray-50 focus-within:border-[#7a3b4b]/20 focus-within:bg-white transition-all duration-300 input-focus-effect">
                        <i class="fas fa-lock text-gray-400 group-focus-within:text-[#7a3b4b] mr-4 transition-colors"></i>
                        <input type="password" name="password" id="passwordInput" placeholder="••••••••"
                            class="bg-transparent w-full focus:outline-none text-gray-700 font-semibold placeholder:text-gray-300" required>

                        <button type="button" onclick="togglePassword()" class="text-gray-300 focus:outline-none hover:text-[#7a3b4b] transition-colors">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-6 space-y-6">
                    <button type="submit"
                        class="w-full bg-[#7a3b4b] hover:bg-[#5d2d39] text-white py-5 rounded-2xl font-bold text-sm shadow-[0_20px_40px_-12px_rgba(122,59,75,0.4)] transition-all transform active:scale-[0.98]">
                        MASUK KE AKUN
                    </button>

                    <p class="text-center text-sm text-gray-500 font-medium">
                        Belum punya akun?
                        <a href="/register" class="text-[#7a3b4b] font-bold hover:underline decoration-2 underline-offset-4">Daftar Sekarang</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>