<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex flex-col md:flex-row">

    <!-- KIRI -->
    <div class="md:w-1/2 w-full bg-gray-200 flex items-center justify-center p-10">
        <div class="text-center">
            <img src="/logo.png" class="w-32 md:w-44 mx-auto mb-4">
            <h1 class="text-lg md:text-2xl font-bold text-blue-800">
                CODIASYNC
            </h1>
        </div>
    </div>

    
    <div class="md:w-1/2 w-full flex items-center justify-center bg-white px-6 py-10">

        <div class="w-full max-w-md md:max-w-lg lg:max-w-xl p-6 md:p-10 bg-white rounded-2xl shadow-xl">

            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                Login Pengguna
            </h2>
            <p class="text-gray-500 mb-6 text-sm md:text-base">
                Login menggunakan akun terdaftar
            </p>

            @if(session('error'))
                <div class="mb-4 text-red-500 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block mb-2 text-sm md:text-base font-medium">
                        Email
                    </label>
                    <input type="email" name="email"
                        class="w-full p-3 border rounded-lg bg-gray-50 text-sm md:text-base focus:ring-green-400 focus:border-green-400"
                        placeholder="Masukkan email" required>
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-2 text-sm md:text-base font-medium">
                        Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full p-3 border rounded-lg bg-gray-50 text-sm md:text-base pr-10 focus:ring-green-400 focus:border-green-400"
                            placeholder="Masukkan password" required>

                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-3 text-gray-500">
                            👁️
                        </button>
                    </div>
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full text-white text-sm md:text-base bg-gradient-to-r from-green-400 to-emerald-500 hover:from-green-500 hover:to-emerald-600 rounded-lg px-5 py-3">
                    Login
                </button>
            </form>

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