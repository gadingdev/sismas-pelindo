<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Surat Pelindo</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-blue-900">🏢 PELINDO</h1>
                <p class="text-gray-600 text-sm">Daftar Akun</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nama lengkap" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="nama@pelindo.co.id" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Minimal 8 karakter" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ulangi password" required>
                </div>

                <button type="submit" 
                        class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition font-semibold">
                    Daftar
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
                    Sudah punya akun? Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>