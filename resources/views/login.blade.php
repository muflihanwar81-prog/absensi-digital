<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100">

    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- KIRI -->
        <div class="md:w-1/2 w-full relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 flex items-center justify-center p-10">

            <!-- Background Decoration -->
            <div class="absolute inset-0">
                <div class="absolute top-10 left-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 w-80 h-80 bg-cyan-500/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 text-center max-w-md">
                <div class="w-40 h-40 bg-white rounded-lg p-5 shadow mx-auto mb-6">
                    <img src="{{ asset('images/logo.png') }}"
                        class="w-full h-full object-contain"
                        alt="CODIA Logo">
                </div>

                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-white mb-4">
                    CODIA<span class="text-cyan-400">SYNC</span>
                </h1>
            </div>
        </div>

        <!-- KANAN -->
        <div class="md:w-1/2 w-full flex items-center justify-center px-6 py-10 md:px-10">

            <div
                class="w-full max-w-md md:max-w-lg lg:max-w-xl bg-white/90 backdrop-blur-xl border border-white/70 rounded-3xl shadow-2xl p-6 md:p-10">

                <!-- Header -->
                <div class="mb-8">

                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-2">
                        Login Pengguna
                    </h2>

                    <p class="text-slate-500 text-sm md:text-base leading-relaxed">
                        Masuk menggunakan akun terdaftar untuk mengakses sistem CODIA-SYNC.
                    </p>
                </div>

                <!-- Error Message -->
                @if(session('error'))
                <div
                    class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl">
                    <span class="text-sm font-medium">
                        {{ session('error') }}
                    </span>
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="/login" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block mb-2 text-sm md:text-base font-semibold text-slate-700">
                            Email
                        </label>

                        <div class="relative">

                            <input
                                type="email"
                                name="email"
                                placeholder="Masukkan email"
                                required
                                class="w-full pr-4 py-3.5 rounded-2xl border border-slate-200 bg-slate-50 text-slate-700 text-sm md:text-base focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block mb-2 text-sm md:text-base font-semibold text-slate-700">
                            Password
                        </label>

                        <div class="relative">

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                required
                                class="w-full pr-12 py-3.5 rounded-2xl border border-slate-200 bg-slate-50 text-slate-700 text-sm md:text-base focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition">

                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition">
                                👁️
                            </button>
                        </div>
                    </div>

                    <!-- Button -->
                    <button
                        type="submit"
                        class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-700 to-cyan-500 hover:from-blue-700 hover:via-indigo-800 hover:to-cyan-600 text-white font-bold text-sm md:text-base shadow-lg hover:shadow-2xl hover:scale-[1.01] transition duration-300">
                        Login
                    </button>
                </form>

    <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                    <p class="text-xs md:text-sm text-slate-400">
                        © {{ date('Y') }} CODIA-SYNC. All rights reserved.
                    </p>
                </div>
            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>

</html>