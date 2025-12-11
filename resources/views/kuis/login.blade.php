<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Kuis - Chemistry App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        input, select, button {
            position: relative;
            z-index: 10;
        }
        input:focus, select:focus {
            outline: 2px solid #7c3aed;
            outline-offset: 2px;
        }
        .error-message {
            display: none;
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .error-message.show {
            display: block;
        }
        input.error, select.error {
            border-color: #dc2626 !important;
        }
    </style>
</head>
<body>
    <div class="max-w-md w-full">
        <!-- Back Button -->
        <a href="/" class="inline-flex items-center text-white hover:text-yellow-300 mb-6 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Home
        </a>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-7xl mb-4 animate-bounce">📝</div>
                <h2 class="text-3xl font-bold text-gray-800">Login Kuis</h2>
                <p class="text-gray-600 mt-2">Masukkan data diri untuk memulai kuis interaktif</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Periksa data yang Anda masukkan:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Login -->
            <form method="POST" action="{{ route('kuis.login') }}" id="loginForm" class="space-y-6" novalidate>
                @csrf

                <!-- Nama Field -->
                <div class="space-y-2">
                    <label for="nama" class="block text-gray-700 font-semibold">
                        <span class="flex items-center gap-2">
                            <span class="text-xl">👤</span>
                            Nama Lengkap
                        </span>
                    </label>
                    <input type="text"
                           name="nama"
                           id="nama"
                           required
                           minlength="3"
                           maxlength="100"
                           pattern="[a-zA-Z\s]+"
                           value="{{ old('nama') }}"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none transition duration-200 text-gray-800"
                           placeholder="Contoh: Andi Wijaya"
                           autocomplete="off"
                           autofocus>
                    <p class="text-sm text-gray-500 mt-1">Minimal 3 karakter, hanya huruf dan spasi</p>
                    <p class="error-message" id="nama-error">Nama hanya boleh berisi huruf dan spasi</p>
                </div>

                <!-- Kelas Field -->
                <div class="space-y-2">
                    <label for="kelas" class="block text-gray-700 font-semibold">
                        <span class="flex items-center gap-2">
                            <span class="text-xl">🏫</span>
                            Kelas
                        </span>
                    </label>
                    <select name="kelas"
                            id="kelas"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none transition duration-200 text-gray-800 appearance-none bg-white">
                        <option value="" disabled selected>-- Pilih Kelas --</option>
                        <option value="X IPA 1" {{ old('kelas') == 'X IPA 1' ? 'selected' : '' }}>X IPA 1</option>
                        <option value="X IPA 2" {{ old('kelas') == 'X IPA 2' ? 'selected' : '' }}>X IPA 2</option>
                        <option value="X IPA 3" {{ old('kelas') == 'X IPA 3' ? 'selected' : '' }}>X IPA 3</option>
                        <option value="X IPA 4" {{ old('kelas') == 'X IPA 4' ? 'selected' : '' }}>X IPA 4</option>
                        <option value="X IPA 5" {{ old('kelas') == 'X IPA 5' ? 'selected' : '' }}>X IPA 5</option>
                    </select>
                    <p class="error-message" id="kelas-error">Silakan pilih kelas</p>
                </div>

                <!-- Absen Field -->
                <div class="space-y-2">
                    <label for="absen" class="block text-gray-700 font-semibold">
                        <span class="flex items-center gap-2">
                            <span class="text-xl">#</span>
                            Nomor Absen
                        </span>
                    </label>
                    <input type="number"
                           name="absen"
                           id="absen"
                           required
                           min="1"
                           max="40"
                           value="{{ old('absen') }}"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none transition duration-200 text-gray-800"
                           placeholder="1 sampai 40">
                    <p class="text-sm text-gray-500 mt-1">Masukkan angka 1-40 sesuai absen di kelas</p>
                    <p class="error-message" id="absen-error">Nomor absen harus antara 1-40</p>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        id="submitBtn"
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="flex items-center justify-center gap-3">
                        <span class="text-2xl">🚀</span>
                        <span class="text-lg" id="btnText">Mulai Kuis</span>
                        <svg id="loadingSpinner" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </form>

            <!-- Info Box -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="bg-blue-50 rounded-xl p-4">
                    <h4 class="font-bold text-blue-800 mb-2 flex items-center gap-2">
                        <span class="text-xl">ℹ️</span>
                        Informasi Kuis:
                    </h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Total 15 soal pilihan ganda</li>
                        <li>• Waktu pengerjaan tidak dibatasi</li>
                        <li>• Minimal nilai kelulusan: 60</li>
                        <li>• Hasil langsung bisa dilihat setelah submit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // FIXED: Enhanced form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const btnText = document.getElementById('btnText');
            
            const namaInput = document.getElementById('nama');
            const kelasInput = document.getElementById('kelas');
            const absenInput = document.getElementById('absen');
            
            const namaError = document.getElementById('nama-error');
            const kelasError = document.getElementById('kelas-error');
            const absenError = document.getElementById('absen-error');

            // FIXED: Real-time validation
            namaInput.addEventListener('input', function() {
                validateNama();
            });

            kelasInput.addEventListener('change', function() {
                validateKelas();
            });

            absenInput.addEventListener('input', function() {
                validateAbsen();
            });

            function validateNama() {
                const nama = namaInput.value.trim();
                const pattern = /^[a-zA-Z\s]+$/;
                
                if (nama.length < 3) {
                    showError(namaInput, namaError, 'Nama minimal 3 karakter');
                    return false;
                } else if (nama.length > 100) {
                    showError(namaInput, namaError, 'Nama maksimal 100 karakter');
                    return false;
                } else if (!pattern.test(nama)) {
                    showError(namaInput, namaError, 'Nama hanya boleh berisi huruf dan spasi');
                    return false;
                } else {
                    hideError(namaInput, namaError);
                    return true;
                }
            }

            function validateKelas() {
                if (!kelasInput.value) {
                    showError(kelasInput, kelasError, 'Silakan pilih kelas');
                    return false;
                } else {
                    hideError(kelasInput, kelasError);
                    return true;
                }
            }

            function validateAbsen() {
                const absen = parseInt(absenInput.value);
                
                if (isNaN(absen) || absen < 1 || absen > 40) {
                    showError(absenInput, absenError, 'Nomor absen harus antara 1-40');
                    return false;
                } else {
                    hideError(absenInput, absenError);
                    return true;
                }
            }

            function showError(input, errorElement, message) {
                input.classList.add('error');
                errorElement.textContent = message;
                errorElement.classList.add('show');
            }

            function hideError(input, errorElement) {
                input.classList.remove('error');
                errorElement.classList.remove('show');
            }

            // FIXED: Form submission validation
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const isNamaValid = validateNama();
                const isKelasValid = validateKelas();
                const isAbsenValid = validateAbsen();

                if (!isNamaValid || !isKelasValid || !isAbsenValid) {
                    // Scroll to first error
                    const firstError = document.querySelector('.error');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                    return false;
                }

                // Show loading
                submitBtn.disabled = true;
                loadingSpinner.classList.remove('hidden');
                btnText.textContent = 'Memproses...';

                // Submit form
                form.submit();
            });

            // Auto-focus first input
            namaInput.focus();
        });
    </script>
</body>
</html>