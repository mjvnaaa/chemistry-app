@extends('layout')

@section('title', 'Login Guru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-700 to-indigo-800 flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        
        {{-- Tombol Kembali ke Home (Elegan/Outline) - PANAH GANDA SUDAH DIPERBAIKI --}}
        <a href="{{ route('landing') }}"
           class="inline-flex items-center text-white bg-white/20 backdrop-blur-sm border border-white/50 hover:bg-white/30 font-semibold py-2 px-5 rounded-full transition duration-300 transform hover:scale-105 shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Home
        </a>

        {{-- Login Card --}}
        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10 relative z-10 border border-gray-100">
            
            {{-- Header --}}
            <header class="text-center mb-8">
                <div class="text-7xl mb-4 text-purple-600">👨‍🏫</div>
                <h1 class="text-4xl font-extrabold text-gray-900">Login Guru</h1>
                <p class="text-gray-500 mt-2">Akses Dashboard Monitoring Hasil Kuis Siswa</p>
            </header>

            {{-- Alert Messages --}}
            @if(session('error'))
                @include('components.alert', ['type' => 'error', 'message' => session('error')])
            @endif

            @if(session('success'))
                @include('components.alert', ['type' => 'success', 'message' => session('success')])
            @endif

            @if(session('info'))
                @include('components.alert', ['type' => 'blue', 'message' => session('info')])
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('guru.auth') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <span class="text-xl text-purple-600">🔐</span>
                        Password Guru
                    </label>
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           autofocus
                           autocomplete="current-password"
                           minlength="6"
                           class="appearance-none block w-full px-4 py-3 border-2 border-gray-300 rounded-xl placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 ease-in-out
                                  @error('password') border-red-500 ring-red-500 @enderror"
                           placeholder="Masukkan password rahasia">
                    
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-extrabold text-lg py-3 rounded-xl 
                               transition-all duration-300 transform hover:scale-[1.01] shadow-lg hover:shadow-xl ring-4 ring-purple-300 ring-opacity-50 
                               flex items-center justify-center gap-2">
                    <span class="text-xl">🔓</span>
                    Masuk Dashboard
                </button>
            </form>

            {{-- Info Section --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-5">
                    <h3 class="font-bold text-purple-800 mb-3 text-lg flex items-center gap-2">
                        <span>📊</span>
                        Fitur Dashboard Guru
                    </h3>
                    <ul class="text-sm text-purple-700 space-y-2 list-disc list-inside">
                        <li>Monitoring hasil kuis real-time</li>
                        <li>Statistik nilai siswa (Rata-rata, Lulus/Tidak Lulus, Tertinggi/Terendah)</li>
                        <li>Export data lengkap ke format CSV</li>
                        <li>Analisis performa kelas</li>
                    </ul>
                </div>
            </div>

            {{-- Security Note --}}
            <footer class="mt-6 text-center text-xs text-gray-400">
                <p class="flex items-center justify-center gap-1">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Koneksi aman dan terenkripsi. Hak akses terbatas.
                </p>
            </footer>
        </div>

        {{-- Additional Help --}}
        <div class="mt-6 text-center text-white text-sm">
            <p class="opacity-80">Lupa password? Silakan hubungi administrator sistem Anda.</p>
        </div>
    </div>
</div>
@endsection