@extends('layout')

@section('title', 'Home - Chemistry App')

@section('content')
<!-- Hero Section -->
<div class="min-h-screen gradient-bg flex items-center justify-center px-4 relative">
    <!-- Animated Background Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white opacity-10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-300 opacity-10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="max-w-6xl mx-auto text-center relative z-10 fade-in">
        <!-- Hero Title -->
        <div class="mb-16">
            <!-- Animated Icon -->
            <div class="text-8xl mb-8 animate-bounce">⚛️</div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 drop-shadow-2xl leading-tight">
                Gaya Antar Molekul dan<br>
                <span class="text-yellow-300">Sifat Fisika Zat</span>
            </h1>
            <p class="text-xl md:text-2xl text-purple-100 mb-8 max-w-3xl mx-auto">
                Pelajari kimia dengan cara yang <span class="font-bold text-yellow-300">interaktif</span>, 
                <span class="font-bold text-yellow-300">menyenangkan</span>, dan 
                <span class="font-bold text-yellow-300">mudah dipahami</span>!
            </p>
            
            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap gap-4 justify-center mb-12">
                <a href="#tujuan" class="bg-white text-purple-600 font-bold py-4 px-8 rounded-full shadow-2xl hover:shadow-purple-500/50 hover:scale-105 transition-all duration-300">
                    🎯 Mulai Belajar
                </a>
                <a href="{{ route('simulasi') }}" class="bg-yellow-400 text-purple-900 font-bold py-4 px-8 rounded-full shadow-2xl hover:shadow-yellow-400/50 hover:scale-105 transition-all duration-300">
                    🔬 Lihat Simulasi
                </a>
            </div>

            <!-- Scroll Down Indicator - More Attractive -->
            <div class="mt-16">
                <a href="#tujuan" class="inline-flex flex-col items-center text-white hover:text-yellow-300 transition-all duration-300 group">
                    <span class="text-sm mb-3 font-semibold tracking-wide">Scroll untuk Eksplorasi</span>
                    <div class="animate-bounce group-hover:animate-pulse">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tujuan Pembelajaran Section -->
<div id="tujuan" class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-20 px-4">
    <div class="max-w-6xl mx-auto fade-in">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="inline-block bg-purple-100 text-purple-600 px-6 py-2 rounded-full text-sm font-bold mb-4">
                LEARNING OBJECTIVES
            </span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-4">
                🎯 Tujuan Pembelajaran
            </h2>
            <p class="text-gray-600 text-lg md:text-xl max-w-3xl mx-auto">
                Setelah mempelajari materi ini, kamu akan mampu menguasai:
            </p>
        </div>

        <!-- Tujuan Cards - Enhanced Design -->
        <div class="grid md:grid-cols-2 gap-6 mb-16">
            <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-blue-500 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 fade-in">
                <div class="flex items-start gap-4">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl w-14 h-14 flex items-center justify-center text-white font-bold text-xl flex-shrink-0 shadow-lg">
                        1
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 mb-2 text-lg">Identifikasi Jenis Gaya</h3>
                        <p class="text-gray-600">Mengidentifikasi jenis-jenis gaya antar molekul dengan tepat</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-purple-500 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 fade-in" style="animation-delay: 0.1s;">
                <div class="flex items-start gap-4">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl w-14 h-14 flex items-center justify-center text-white font-bold text-xl flex-shrink-0 shadow-lg">
                        2
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 mb-2 text-lg">Membedakan Gaya</h3>
                        <p class="text-gray-600">Menjelaskan perbedaan gaya London, dipol-dipol, dan ikatan hidrogen</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-pink-500 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 fade-in" style="animation-delay: 0.2s;">
                <div class="flex items-start gap-4">
                    <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl w-14 h-14 flex items-center justify-center text-white font-bold text-xl flex-shrink-0 shadow-lg">
                        3
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 mb-2 text-lg">Analisis Faktor</h3>
                        <p class="text-gray-600">Menganalisis faktor-faktor yang mempengaruhi kekuatan gaya antar molekul</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-green-500 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 fade-in" style="animation-delay: 0.3s;">
                <div class="flex items-start gap-4">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl w-14 h-14 flex items-center justify-center text-white font-bold text-xl flex-shrink-0 shadow-lg">
                        4
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 mb-2 text-lg">Hubungkan Konsep</h3>
                        <p class="text-gray-600">Menghubungkan gaya antar molekul dengan sifat fisika zat</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-orange-500 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 md:col-span-2 fade-in" style="animation-delay: 0.4s;">
                <div class="flex items-start gap-4">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl w-14 h-14 flex items-center justify-center text-white font-bold text-xl flex-shrink-0 shadow-lg">
                        5
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 mb-2 text-lg">Prediksi Sifat</h3>
                        <p class="text-gray-600">Memprediksi sifat fisika zat berdasarkan jenis gaya antar molekulnya</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Cards - Enhanced -->
        <div class="text-center mb-12">
            <span class="inline-block bg-blue-100 text-blue-600 px-6 py-2 rounded-full text-sm font-bold mb-4">
                LEARNING MODULES
            </span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-4">
                📚 Modul Pembelajaran
            </h2>
            <p class="text-gray-600 text-lg">Pilih modul untuk memulai perjalanan belajarmu</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <!-- Card Materi -->
            <a href="{{ route('materi') }}" class="group relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
                <!-- Gradient Overlay on Hover -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="text-7xl mb-6 transform group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">📖</div>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-white mb-4 transition-colors duration-300">Materi</h3>
                    <p class="text-gray-600 group-hover:text-white/90 mb-6 transition-colors duration-300">
                        Pelajari konsep dasar gaya antar molekul dengan penjelasan lengkap
                    </p>
                    <div class="flex items-center text-purple-600 group-hover:text-white font-semibold transition-colors duration-300">
                        <span>Mulai Belajar</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card Simulasi -->
            <a href="{{ route('simulasi') }}" class="group relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="text-7xl mb-6 transform group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">🔬</div>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-white mb-4 transition-colors duration-300">Simulasi</h3>
                    <p class="text-gray-600 group-hover:text-white/90 mb-6 transition-colors duration-300">
                        Visualisasi interaktif molekul & pengaruh suhu secara real-time
                    </p>
                    <div class="flex items-center text-green-600 group-hover:text-white font-semibold transition-colors duration-300">
                        <span>Coba Sekarang</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card Kuis -->
            <a href="{{ route('kuis.index') }}" class="group relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="text-7xl mb-6 transform group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">📝</div>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-white mb-4 transition-colors duration-300">Kuis</h3>
                    <p class="text-gray-600 group-hover:text-white/90 mb-6 transition-colors duration-300">
                        Uji pemahamanmu dengan soal interaktif dan dapatkan feedback
                    </p>
                    <div class="flex items-center text-orange-600 group-hover:text-white font-semibold transition-colors duration-300">
                        <span>Mulai Kuis</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Teacher Login - Enhanced -->
        <div class="mt-16 text-center">
            <div class="inline-block bg-gradient-to-r from-purple-50 to-blue-50 rounded-2xl p-8 shadow-xl">
                <p class="text-gray-600 mb-4 text-lg">Untuk Guru:</p>
                <a href="{{ route('guru.login') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    <span class="text-2xl">👨‍🏫</span>
                    <span>Login sebagai Guru</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from { 
        opacity: 0; 
        transform: translateY(30px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.fade-in {
    animation: fade-in 0.8s ease-out forwards;
}

html {
    scroll-behavior: smooth;
}

/* Enhanced Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}
</style>
@endsection