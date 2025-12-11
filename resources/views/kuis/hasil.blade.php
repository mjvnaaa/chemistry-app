@extends('layout')

@section('title', 'Hasil Kuis')

@section('content')
<div class="min-h-screen gradient-bg flex items-center justify-center px-4 py-8">
    <div class="max-w-4xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-7xl mb-4">
                    @if($nilai >= 80)
                        🎉
                    @elseif($nilai >= 60)
                        😊
                    @else
                        📚
                    @endif
                </div>

                <h2 class="text-3xl font-bold text-gray-800 mb-2">Kuis Selesai!</h2>
                <p class="text-gray-600">Berikut adalah hasil kuis Gaya Antarmolekul Anda</p>
            </div>

            <!-- Ringkasan Hasil -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Nilai -->
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 text-center">
                    <div class="text-5xl font-bold
                        @if($nilai >= 80) text-green-600
                        @elseif($nilai >= 60) text-yellow-600
                        @else text-red-600
                        @endif">
                        {{ number_format($nilai, 0) }}
                    </div>
                    <p class="text-gray-700 font-medium mt-2">Nilai Akhir</p>
                </div>

                <!-- Benar -->
                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-6 text-center">
                    <div class="text-5xl font-bold text-green-700">{{ $benar }}</div>
                    <p class="text-gray-700 font-medium mt-2">Jawaban Benar</p>
                </div>

                <!-- Salah -->
                <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-6 text-center">
                    <div class="text-5xl font-bold text-red-700">{{ 15 - $benar }}</div>
                    <p class="text-gray-700 font-medium mt-2">Jawaban Salah</p>
                </div>
            </div>

            <!-- Status Kelulusan -->
            <div class="mb-8">
                @if($nilai >= 80)
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-r-lg">
                        <div class="flex items-center gap-4">
                            <div class="text-4xl">🎉</div>
                            <div>
                                <h3 class="text-xl font-bold text-green-800">Luar Biasa!</h3>
                                <p class="text-green-700">Anda sangat memahami materi Gaya Antarmolekul. Pertahankan!</p>
                            </div>
                        </div>
                    </div>
                @elseif($nilai >= 60)
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-r-lg">
                        <div class="flex items-center gap-4">
                            <div class="text-4xl">😊</div>
                            <div>
                                <h3 class="text-xl font-bold text-yellow-800">Bagus!</h3>
                                <p class="text-yellow-700">Anda sudah memahami materi dengan cukup baik. Tingkatkan lagi pemahamannya!</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-lg">
                        <div class="flex items-center gap-4">
                            <div class="text-4xl">📚</div>
                            <div>
                                <h3 class="text-xl font-bold text-red-800">Perlu Belajar Lagi</h3>
                                <p class="text-red-700">Pelajari kembali materi Gaya Antarmolekul untuk meningkatkan pemahaman.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Detail Hasil Per Soal -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Detail Jawaban</h3>
                    <button onclick="toggleAllDetails()" 
                            class="text-purple-600 hover:text-purple-800 font-semibold flex items-center gap-2 px-4 py-2 bg-purple-50 rounded-lg">
                        <span id="toggle-all-text">Buka Semua Pembahasan</span>
                        <span id="toggle-all-icon">▼</span>
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach($detailJawaban as $detail)
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <!-- Header Soal -->
                            <div class="bg-gray-50 p-4 flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-gray-800">Soal {{ $detail['nomor'] }}</span>
                                    <span class="ml-4 px-3 py-1 rounded-full text-sm font-medium
                                        {{ $detail['benar'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $detail['benar'] ? '✅ Benar' : '❌ Salah' }}
                                    </span>
                                </div>
                                <button onclick="toggleDetail({{ $detail['nomor'] }})"
                                        class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2">
                                    <span id="icon-{{ $detail['nomor'] }}">▼</span>
                                    <span>Pembahasan</span>
                                </button>
                            </div>

                            <!-- Konten Soal -->
                            <div class="p-4">
                                <p class="text-gray-800 mb-3">{!! $detail['pertanyaan'] !!}</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <!-- Jawaban Siswa -->
                                    <div class="{{ $detail['benar'] ? 'bg-green-50' : 'bg-red-50' }} p-4 rounded-lg">
                                        <p class="text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</p>
                                        <p class="font-bold {{ $detail['benar'] ? 'text-green-700' : 'text-red-700' }}">
                                            {{ $detail['opsi_teks'] ?? '(Tidak menjawab)' }}
                                        </p>
                                    </div>

                                    <!-- Jawaban Benar -->
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <p class="text-sm font-medium text-gray-600 mb-1">Jawaban yang Benar:</p>
                                        <p class="font-bold text-blue-700">{{ $detail['kunci_teks'] }}</p>
                                    </div>
                                </div>

                                <!-- Pembahasan (Tersembunyi) -->
                                <div id="detail-{{ $detail['nomor'] }}" class="hidden mt-4">
                                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
                                        <h4 class="font-bold text-gray-800 mb-2">📚 Pembahasan:</h4>
                                        <p class="text-gray-700">{{ $detail['pembahasan'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons - UPDATED: Only 2 buttons now -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('materi') }}"
                   class="block bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-center">
                    <span class="flex items-center justify-center gap-3">
                        <span class="text-xl">📖</span>
                        <span class="text-lg">Review Materi</span>
                    </span>
                </a>
                
                <a href="{{ route('landing') }}"
                   class="block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-center">
                    <span class="flex items-center justify-center gap-3">
                        <span class="text-xl">🏠</span>
                        <span class="text-lg">Kembali ke Home</span>
                    </span>
                </a>
            </div>

            <!-- Tips -->
            <div class="mt-8 text-center">
                <p class="text-gray-600 text-sm">
                    <span class="font-bold">Tips:</span> Pelajari pembahasan setiap soal untuk memahami konsep yang masih kurang.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDetail(nomor) {
        const detail = document.getElementById('detail-' + nomor);
        const icon = document.getElementById('icon-' + nomor);
        
        if (detail.classList.contains('hidden')) {
            detail.classList.remove('hidden');
            icon.textContent = '▲';
        } else {
            detail.classList.add('hidden');
            icon.textContent = '▼';
        }
    }

    function toggleAllDetails() {
        const allDetails = document.querySelectorAll('[id^="detail-"]');
        const allIcons = document.querySelectorAll('[id^="icon-"]');
        const toggleAllIcon = document.getElementById('toggle-all-icon');
        const toggleAllText = document.getElementById('toggle-all-text');
        
        const isHidden = allDetails[0].classList.contains('hidden');
        
        allDetails.forEach(detail => {
            if (isHidden) {
                detail.classList.remove('hidden');
            } else {
                detail.classList.add('hidden');
            }
        });
        
        allIcons.forEach(icon => {
            icon.textContent = isHidden ? '▲' : '▼';
        });
        
        toggleAllIcon.textContent = isHidden ? '▲' : '▼';
        toggleAllText.textContent = isHidden ? 'Tutup Semua Pembahasan' : 'Buka Semua Pembahasan';
    }
</script>

<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    a, button {
        cursor: pointer;
        position: relative;
        z-index: 10;
        transition: all 0.3s ease;
    }
    
    a:hover, button:hover {
        transform: translateY(-2px);
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .text-5xl {
            font-size: 3rem;
        }
        
        .text-3xl {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 640px) {
        .text-5xl {
            font-size: 2.5rem;
        }
        
        .text-3xl {
            font-size: 1.75rem;
        }
        
        .p-8 {
            padding: 1.5rem;
        }
    }
</style>
@endsection