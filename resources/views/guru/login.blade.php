@extends('layout')

@section('title', 'Login Guru')

@section('content')
<div class="min-h-screen gradient-bg flex items-center justify-center px-4">
    <div class="max-w-md w-full">
        <!-- Back Button -->
        <a href="{{ route('landing') }}" 
           class="inline-flex items-center text-white hover:text-purple-200 mb-6 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Home
        </a>
        
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="text-6xl mb-4 animate-bounce">👨‍🏫</div>
                <h2 class="text-3xl font-bold text-gray-800">Login Guru</h2>
                <p class="text-gray-600 mt-2">Dashboard Monitoring Hasil Kuis Siswa</p>
            </div>

            <!-- Alert Messages -->
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-start gap-2" role="alert">
                    <span class="text-xl">❌</span>
                    <div>
                        <p class="font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-start gap-2" role="alert">
                    <span class="text-xl">✅</span>
                    <div>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 px-4 py-3 rounded-lg mb-4 flex items-start gap-2" role="alert">
                    <span class="text-xl">ℹ️</span>
                    <div>
                        <p class="font-semibold">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('guru.auth') }}" class="space-y-6">
                @csrf
                
                <div class="relative z-10">
                    <label for="password" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                        <span class="text-xl">🔐</span>
                        Password Guru
                    </label>
                    <input type="password" 
                           id="password"
                           name="password" 
                           required 
                           autofocus
                           autocomplete="current-password"
                           minlength="6"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition relative z-20 bg-white @error('password') border-red-500 @enderror"
                           placeholder="Masukkan password guru">
                    
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Password Hint -->
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <span>💡</span>
                            <span><strong>Default password:</strong> <code class="bg-gray-200 px-2 py-1 rounded text-purple-700 font-mono">guru2024</code></span>
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-3 rounded-lg transition-all transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <span class="text-xl">🔓</span>
                    Masuk Dashboard
                </button>
            </form>

            <!-- Info Section -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <h3 class="font-semibold text-purple-800 mb-2 flex items-center gap-2">
                        <span>📊</span>
                        Fitur Dashboard Guru:
                    </h3>
                    <ul class="text-sm text-purple-700 space-y-1">
                        <li>✓ Monitoring hasil kuis real-time</li>
                        <li>✓ Statistik nilai siswa lengkap</li>
                        <li>✓ Export data ke format CSV</li>
                        <li>✓ Analisis performa kelas</li>
                    </ul>
                </div>
            </div>

            <!-- Security Note -->
            <div class="mt-4 text-center text-xs text-gray-500">
                <p class="flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Koneksi aman dan terenkripsi
                </p>
            </div>
        </div>

        <!-- Additional Help -->
        <div class="mt-6 text-center text-white text-sm">
            <p>Lupa password? Hubungi administrator sistem</p>
        </div>
    </div>
</div>

<style>
.gradient-bg {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    z-index: 0;
}

/* Ensure all interactive elements are clickable */
input[type="password"],
input[type="text"],
button[type="submit"],
a {
    position: relative;
    z-index: 10;
    pointer-events: auto !important;
}

/* Remove any blocking overlays */
.bg-white {
    position: relative;
    z-index: 1;
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-bounce {
    animation: bounce 2s infinite;
}

/* Fix for input focus */
input:focus {
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.3) !important;
}
</style>
@endsection