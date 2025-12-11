<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center px-4">
    <div class="max-w-2xl w-full text-center">
        <!-- Error Animation -->
        <div class="mb-8 animate-bounce">
            <span class="text-9xl">🔍</span>
        </div>

        <!-- Error Content -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
            <h1 class="text-6xl md:text-8xl font-extrabold text-gray-800 mb-4">404</h1>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-700 mb-4">
                Oops! Halaman Tidak Ditemukan
            </h2>
            <p class="text-gray-600 text-lg mb-8">
                Sepertinya halaman yang Anda cari sedang bermain petak umpet. 
                Mari kembali ke halaman utama! 😊
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('landing') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <span class="text-xl">🏠</span>
                    <span>Kembali ke Home</span>
                </a>
                
                <button onclick="history.back()" 
                        class="inline-flex items-center justify-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <span class="text-xl">⬅️</span>
                    <span>Halaman Sebelumnya</span>
                </button>
            </div>

            <!-- Helpful Links -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-4">Mungkin Anda mencari:</p>
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="{{ route('materi') }}" class="text-purple-600 hover:text-purple-800 font-semibold text-sm">
                        📚 Materi
                    </a>
                    <a href="{{ route('simulasi') }}" class="text-purple-600 hover:text-purple-800 font-semibold text-sm">
                        🔬 Simulasi
                    </a>
                    <a href="{{ route('kuis') }}" class="text-purple-600 hover:text-purple-800 font-semibold text-sm">
                        📝 Kuis
                    </a>
                    <a href="{{ route('guru.login') }}" class="text-purple-600 hover:text-purple-800 font-semibold text-sm">
                        👨‍🏫 Dashboard Guru
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>