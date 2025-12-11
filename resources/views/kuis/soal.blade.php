@extends('layout')

@section('title', 'Soal Kuis')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="text-3xl">📝</span>
                        Kuis: Gaya Antar Molekul
                    </h1>
                    <p class="text-gray-600 mt-2">
                        <span class="font-semibold">{{ session('siswa_nama') }}</span> • 
                        <span class="font-semibold">{{ session('siswa_kelas') }}</span> • 
                        Absen <span class="font-semibold">{{ session('siswa_absen') }}</span>
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Soal</p>
                    <p class="text-3xl font-bold text-purple-600">{{ count($soal) }}</p>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold text-gray-700">Progress Mengerjakan</span>
                <span id="progress-text" class="text-sm font-semibold text-purple-600">0/{{ count($soal) }}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div id="progress-bar" class="bg-gradient-to-r from-purple-500 to-blue-500 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
        </div>

        <!-- Form Soal -->
        <form method="POST" action="{{ route('kuis.submit') }}" id="quiz-form">
            @csrf

            @foreach($soal as $index => $item)
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in question-card" style="animation-delay: {{ $index * 0.1 }}s;">
                <div class="flex items-start gap-4 mb-4">
                    <div class="bg-gradient-to-br from-purple-500 to-blue-500 text-white rounded-xl w-12 h-12 flex items-center justify-center font-bold text-xl flex-shrink-0 shadow-lg">
                        {{ $item['nomor'] }}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800">{{ $item['pertanyaan'] }}</h3>
                    </div>
                </div>

                <div class="space-y-2 ml-16">
                    @foreach($item['pilihan'] as $key => $value)
                    <label class="flex items-center p-4 hover:bg-purple-50 rounded-lg cursor-pointer transition-all duration-200 border-2 border-transparent hover:border-purple-300 group">
                        <input type="radio" 
                               name="jawaban[{{ $index }}]" 
                               value="{{ $key }}" 
                               class="mr-3 w-5 h-5 text-purple-600 focus:ring-2 focus:ring-purple-500 answer-radio" 
                               data-question="{{ $index }}"
                               required>
                        <span class="text-gray-700 group-hover:text-gray-900 font-medium">{{ $value }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach

            <!-- Submit Button -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl shadow-lg p-6 border-2 border-green-300 fade-in">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="text-4xl">✅</span>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Sudah yakin dengan jawabanmu?</h3>
                            <p class="text-sm text-gray-600">Pastikan semua soal sudah terjawab sebelum submit</p>
                        </div>
                    </div>
                </div>
                
                <button type="submit" 
                        id="submit-btn"
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="flex items-center justify-center gap-2">
                        <span class="text-xl">📤</span>
                        <span>Submit Jawaban</span>
                    </span>
                </button>
            </div>
        </form>

        <!-- Warning jika belum semua terjawab -->
        <div id="warning-incomplete" class="hidden bg-yellow-50 border-2 border-yellow-300 rounded-xl p-4 mt-4">
            <div class="flex items-start gap-3">
                <span class="text-2xl">⚠️</span>
                <div>
                    <p class="font-bold text-yellow-800">Masih ada soal yang belum dijawab!</p>
                    <p class="text-sm text-yellow-700">Silakan lengkapi semua jawaban sebelum submit.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

.question-card {
    opacity: 0;
    animation: fadeIn 0.6s ease-out forwards;
}

/* Custom Radio Button */
input[type="radio"] {
    cursor: pointer;
}

input[type="radio"]:checked + span {
    color: #7c3aed;
    font-weight: 600;
}

input[type="radio"]:checked {
    accent-color: #7c3aed;
}

label:has(input[type="radio"]:checked) {
    background-color: #f3e8ff;
    border-color: #7c3aed !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quiz-form');
    const submitBtn = document.getElementById('submit-btn');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const warningDiv = document.getElementById('warning-incomplete');
    const totalQuestions = {{ count($soal) }};
    const answerRadios = document.querySelectorAll('.answer-radio');

    // Update progress when answer is selected
    answerRadios.forEach(radio => {
        radio.addEventListener('change', updateProgress);
    });

    function updateProgress() {
        const answeredQuestions = new Set();
        
        answerRadios.forEach(radio => {
            if (radio.checked) {
                answeredQuestions.add(radio.dataset.question);
            }
        });

        const answered = answeredQuestions.size;
        const progress = (answered / totalQuestions) * 100;
        
        progressBar.style.width = progress + '%';
        progressText.textContent = answered + '/' + totalQuestions;

        // Change color based on progress
        if (progress === 100) {
            progressBar.className = 'bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full transition-all duration-300';
            warningDiv.classList.add('hidden');
        } else if (progress >= 50) {
            progressBar.className = 'bg-gradient-to-r from-yellow-500 to-orange-500 h-3 rounded-full transition-all duration-300';
        } else {
            progressBar.className = 'bg-gradient-to-r from-purple-500 to-blue-500 h-3 rounded-full transition-all duration-300';
        }
    }

    // Form validation before submit
    form.addEventListener('submit', function(e) {
        const answeredQuestions = new Set();
        
        answerRadios.forEach(radio => {
            if (radio.checked) {
                answeredQuestions.add(radio.dataset.question);
            }
        });

        if (answeredQuestions.size < totalQuestions) {
            e.preventDefault();
            warningDiv.classList.remove('hidden');
            
            // Scroll to warning
            warningDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Shake animation
            warningDiv.style.animation = 'shake 0.5s';
            setTimeout(() => {
                warningDiv.style.animation = '';
            }, 500);
            
            return false;
        }

        // Confirm submission
        if (!confirm('Yakin ingin submit jawaban? Pastikan semua jawaban sudah benar!')) {
            e.preventDefault();
            return false;
        }

        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="flex items-center justify-center gap-2"><span class="animate-spin">⏳</span><span>Mengirim...</span></span>';
    });
});

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    75% { transform: translateX(10px); }
}
</script>
@endsection