@extends('layout')

@section('title', 'Materi Pembelajaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 py-12 px-4">
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumb Navigation -->
        <nav class="mb-6 fade-in">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('landing') }}" class="text-purple-600 hover:text-purple-800 font-semibold">🏠 Home</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-600 font-semibold">📖 Materi Pembelajaran</li>
            </ol>
        </nav>

        <!-- Header with Progress -->
        <div class="mb-8 fade-in">
            <div class="bg-white rounded-3xl shadow-2xl p-8 text-center relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, #667eea 10px, #667eea 20px);"></div>
                </div>
                
                <div class="relative z-10">
                    <div class="inline-block bg-purple-100 text-purple-600 px-6 py-2 rounded-full text-sm font-bold mb-4">
                        LEARNING MATERIAL
                    </div>
                    <div class="text-6xl mb-4">🧬</div>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-3">Materi Pembelajaran</h1>
                    <p class="text-gray-600 text-lg md:text-xl">Gaya Antar Molekul dan Sifat Fisika Zat</p>
                    
                    <!-- Progress Bar -->
                    <div class="mt-6 max-w-md mx-auto">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress Belajar</span>
                            <span id="progressText">0%</span>
                        </div>
                        <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div id="progressBar" class="h-full bg-gradient-to-r from-purple-500 to-blue-500 rounded-full transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tujuan Pembelajaran - Enhanced -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-3xl shadow-2xl p-8 mb-8 text-white fade-in relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-5xl">🎯</span>
                    <h2 class="text-3xl font-bold">Tujuan Pembelajaran</h2>
                </div>
                <p class="mb-6 opacity-90 text-lg">Setelah mempelajari materi ini, kamu diharapkan mampu:</p>
                <ul class="space-y-4">
                    @foreach($tujuanPembelajaran as $index => $tujuan)
                    <li class="flex items-start gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300">
                        <span class="bg-white text-purple-600 rounded-xl w-10 h-10 flex items-center justify-center font-bold flex-shrink-0 shadow-lg">
                            {{ $index + 1 }}
                        </span>
                        <span class="pt-2 text-lg">{{ $tujuan }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Cards Materi with better spacing and design -->
        <div class="space-y-8">
            @foreach($materi as $index => $item)
            <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden border-l-8 fade-in materi-card
                {{ $index == 0 ? 'border-blue-500' : ($index == 1 ? 'border-purple-500' : ($index == 2 ? 'border-pink-500' : 'border-green-500')) }}"
                style="animation-delay: {{ $index * 0.1 }}s;">
                <div class="p-8">
                    <div class="flex items-start gap-6">
                        <!-- Enhanced Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center font-bold text-3xl shadow-2xl transform hover:scale-110 hover:rotate-6 transition-all duration-300
                                {{ $index == 0 ? 'bg-gradient-to-br from-blue-500 to-blue-600 text-white' : 
                                   ($index == 1 ? 'bg-gradient-to-br from-purple-500 to-purple-600 text-white' : 
                                   ($index == 2 ? 'bg-gradient-to-br from-pink-500 to-pink-600 text-white' : 
                                   'bg-gradient-to-br from-green-500 to-green-600 text-white')) }}">
                                {{ $index + 1 }}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <h3 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                                @if($index == 0)
                                    <span class="text-4xl">⚡</span>
                                @elseif($index == 1)
                                    <span class="text-4xl">⚛️</span>
                                @elseif($index == 2)
                                    <span class="text-4xl">📊</span>
                                @else
                                    <span class="text-4xl">🔬</span>
                                @endif
                                {{ $item['judul'] }}
                            </h3>

                            <div class="prose prose-lg max-w-none">
                                <p class="text-gray-700 leading-relaxed text-lg mb-6">{{ $item['isi'] }}</p>
                            </div>

                            <!-- Sub-materi with enhanced styling -->
                            @if(isset($item['sub']))
                            <div class="mt-6 space-y-4">
                                @foreach($item['sub'] as $subIndex => $sub)
                                <div class="group bg-gradient-to-r from-{{ $subIndex == 0 ? 'pink' : ($subIndex == 1 ? 'blue' : 'purple') }}-50 to-{{ $subIndex == 0 ? 'red' : ($subIndex == 1 ? 'cyan' : 'indigo') }}-50 p-6 rounded-2xl border-2 border-{{ $subIndex == 0 ? 'pink' : ($subIndex == 1 ? 'blue' : 'purple') }}-200 hover:border-{{ $subIndex == 0 ? 'pink' : ($subIndex == 1 ? 'blue' : 'purple') }}-400 transition-all duration-300 hover:shadow-lg">
                                    <h4 class="font-bold text-{{ $subIndex == 0 ? 'pink' : ($subIndex == 1 ? 'blue' : 'purple') }}-700 text-xl mb-3 flex items-center gap-2">
                                        <span class="text-2xl">{{ ['🔴', '🔵', '🟣'][$subIndex] }}</span>
                                        {{ chr(97 + $subIndex) }}. {{ $sub['nama'] }}
                                    </h4>
                                    <p class="text-gray-700 mb-3 text-base leading-relaxed">{{ $sub['penjelasan'] }}</p>
                                    <div class="bg-white/50 backdrop-blur-sm rounded-xl p-3 mt-3">
                                        <p class="text-sm text-gray-600 italic flex items-start gap-2">
                                            <span class="text-lg">💡</span>
                                                                                    <span>{{ $sub['contoh'] }}</span>
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <!-- Faktor-Faktor with enhanced design -->
                            @if(isset($item['faktor']))
                            <div class="mt-6">
                                <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <span class="text-2xl">📊</span>
                                    Faktor-Faktor yang Mempengaruhi:
                                </h4>
                                <div class="grid md:grid-cols-2 gap-4">
                                    @foreach($item['faktor'] as $faktor)
                                    <div class="bg-gradient-to-br from-pink-50 to-rose-50 p-5 rounded-2xl border-2 border-pink-200 hover:border-pink-400 transition-all duration-300 hover:shadow-lg group">
                                        <div class="flex items-start gap-3">
                                            <div class="bg-pink-100 text-pink-600 rounded-lg w-10 h-10 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                                {{ ['📈','🔍','⚡','💧'][$loop->index] }}
                                            </div>
                                            <div>
                                                <h5 class="font-bold text-pink-700 mb-2 text-lg">{{ $faktor['nama'] }}</h5>
                                                <p class="text-gray-700 text-sm leading-relaxed">{{ $faktor['penjelasan'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Hubungan dengan Sifat Fisika - Enhanced -->
                            @if(isset($item['hubungan']))
                            <div class="mt-6">
                                <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <span class="text-2xl">🔗</span>
                                    Hubungan dengan Sifat Fisika:
                                </h4>
                                <div class="space-y-4">
                                    @foreach($item['hubungan'] as $hubungan)
                                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-5 rounded-2xl border-2 border-green-200 hover:border-green-400 transition-all duration-300 hover:shadow-lg group">
                                        <div class="flex items-start gap-3">
                                            <div class="bg-green-100 text-green-600 rounded-lg w-10 h-10 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                                {{ ['🌡️','⚗️','💨'][$loop->index] }}
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="font-bold text-green-700 mb-2 text-lg">{{ $hubungan['sifat'] }}</h5>
                                                <p class="text-gray-700 mb-3 text-base leading-relaxed">{{ $hubungan['penjelasan'] }}</p>
                                                <div class="bg-white/70 backdrop-blur-sm rounded-xl p-4">
                                                    <p class="text-sm text-gray-700 font-semibold flex items-start gap-2">
                                                        <span class="text-blue-500 text-lg">📌</span>
                                                        <span class="flex-1"><span class="text-green-600">Contoh:</span> {{ $hubungan['contoh'] }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Contoh tambahan with better styling -->
                            @if(isset($item['contoh']))
                            <div class="mt-6 bg-gradient-to-r from-blue-50 to-cyan-50 p-5 rounded-2xl border-2 border-blue-300">
                                <p class="text-blue-800 font-semibold text-lg flex items-start gap-3">
                                    <span class="text-2xl flex-shrink-0">💡</span>
                                    <span>{{ $item['contoh'] }}</span>
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Enhanced Summary Section -->
        <div class="mt-10 bg-gradient-to-r from-yellow-50 to-orange-100 rounded-3xl shadow-2xl p-8 border-4 border-yellow-300 relative overflow-hidden">
            <!-- Decorative Pattern -->
            <div class="absolute top-0 right-0 w-40 h-40 bg-yellow-300 opacity-10 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-orange-300 opacity-10 rounded-full -ml-16 -mb-16"></div>
            
            <div class="relative z-10">
                <h3 class="text-2xl font-bold text-orange-800 mb-6 flex items-center gap-3">
                    <span class="text-4xl">📋</span>
                    Rangkuman Penting
                </h3>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg">
                        <h4 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                            <span class="text-xl">🎯</span>
                            Poin Kunci:
                        </h4>
                        <ul class="space-y-3">
                            @php
                                $poinKunci = [
                                    'Gaya antar molekul BERBEDA dengan ikatan intramolekul',
                                    'Urutan kekuatan: Ikatan Hidrogen > Dipol-Dipol > Gaya London',
                                    'Semakin kuat gaya, semakin tinggi titik didih dan viskositas',
                                    'Massa molekul relatif (Mr) mempengaruhi kekuatan Gaya London'
                                ];
                            @endphp
                            @foreach($poinKunci as $poin)
                            <li class="flex items-start gap-3 group">
                                <span class="bg-purple-100 text-purple-600 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mt-1 flex-shrink-0 group-hover:scale-125 transition-transform duration-300">
                                    ✓
                                </span>
                                <span class="text-gray-700 pt-0.5">{{ $poin }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg">
                        <h4 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                            <span class="text-xl">📈</span>
                            Urutan Kekuatan Gaya:
                        </h4>
                        <div class="relative">
                            <!-- Timeline visualization -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="text-center">
                                    <div class="text-5xl mb-2 animate-pulse">🔴</div>
                                    <p class="text-sm font-bold text-pink-600">Gaya London</p>
                                    <p class="text-xs text-gray-500 font-semibold">(Terlemah)</p>
                                </div>
                                <div class="text-3xl text-gray-400 animate-bounce">→</div>
                                <div class="text-center">
                                    <div class="text-5xl mb-2 animate-pulse" style="animation-delay: 0.3s">🔵</div>
                                    <p class="text-sm font-bold text-blue-600">Dipol-Dipol</p>
                                    <p class="text-xs text-gray-500 font-semibold">(Sedang)</p>
                                </div>
                                <div class="text-3xl text-gray-400 animate-bounce" style="animation-delay: 0.5s">→</div>
                                <div class="text-center">
                                    <div class="text-5xl mb-2 animate-pulse" style="animation-delay: 0.7s">🟣</div>
                                    <p class="text-sm font-bold text-purple-600">Ikatan H</p>
                                    <p class="text-xs text-gray-500 font-semibold">(Terkuat)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Action Buttons -->
        <div class="mt-10 grid md:grid-cols-2 gap-6">
            <a href="{{ route('simulasi') }}" 
               class="group relative bg-gradient-to-r from-purple-600 to-blue-600 text-white py-6 px-8 rounded-2xl text-center font-bold text-xl hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
                <!-- Hover Effect Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-purple-700 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10 flex items-center justify-center gap-4">
                    <span class="text-3xl">🔬</span>
                    <div class="text-left">
                        <div class="text-lg font-semibold opacity-90">Lanjut ke</div>
                        <div class="text-2xl">Simulasi Interaktif</div>
                    </div>
                    <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </a>

            <a href="{{ route('kuis.index') }}" 
               class="group relative bg-gradient-to-r from-blue-600 to-cyan-600 text-white py-6 px-8 rounded-2xl text-center font-bold text-xl hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-cyan-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10 flex items-center justify-center gap-4">
                    <span class="text-3xl">📝</span>
                    <div class="text-left">
                        <div class="text-lg font-semibold opacity-90">Tes Pemahamanmu di</div>
                        <div class="text-2xl">Kuis Interaktif</div>
                    </div>
                    <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
    // Progress tracking for material reading
    document.addEventListener('DOMContentLoaded', function() {
        const materis = document.querySelectorAll('.materi-card');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        
        // Create observer to track which sections are visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('read');
                }
            });
            
            // Calculate progress
            const readMateris = document.querySelectorAll('.materi-card.read').length;
            const totalMateris = materis.length;
            const progress = Math.round((readMateris / totalMateris) * 100);
            
            // Update progress bar
            progressBar.style.width = `${progress}%`;
            progressText.textContent = `${progress}%`;
            
            // Color changes based on progress
            if (progress >= 75) {
                progressBar.className = 'h-full bg-gradient-to-r from-green-500 to-emerald-500 rounded-full transition-all duration-500';
            } else if (progress >= 50) {
                progressBar.className = 'h-full bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full transition-all duration-500';
            } else {
                progressBar.className = 'h-full bg-gradient-to-r from-purple-500 to-blue-500 rounded-full transition-all duration-500';
            }
        }, {
            threshold: 0.3 // Trigger when 30% of card is visible
        });
        
        // Observe each materi card
        materis.forEach(card => {
            observer.observe(card);
        });
    });
</script>

<style>
    .materi-card {
        opacity: 0;
        transform: translateY(20px);
        animation: slideUp 0.6s ease-out forwards;
    }
    
    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .prose {
        line-height: 1.8;
    }
    
    .prose p {
        margin-bottom: 1em;
    }
</style>
@endsection