@extends('layout')

@section('title', 'Dashboard Guru')

@php
    // Definisikan nilai minimum kelulusan dan jumlah soal untuk konsistensi
    $passingGrade = 60;
    $totalQuestions = 15;
@endphp

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-6 border-b pb-4">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 flex items-center">
                        <span class="text-5xl mr-3 text-purple-600">👨‍🏫</span>
                        Dashboard Guru
                    </h1>
                    <p class="text-lg text-gray-600 mt-2">Monitoring Hasil Kuis Siswa - Gaya Antar Molekul</p>
                    @if(Session::has('guru_login_time'))
                        <p class="text-sm text-gray-500 mt-1">
                            Login: {{ Session::get('guru_login_time')->format('d/m/Y H:i') }} WIB
                        </p>
                    @endif
                </div>
                
                <div class="flex flex-wrap gap-3">
                    {{-- Tombol Download CSV --}}
                    @if(count($data) > 0)
                        <a href="{{ route('guru.export') }}"
                           class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-xl flex items-center gap-2 transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <span class="text-xl">📊</span>
                            Download CSV
                        </a>
                    @else
                        <button disabled
                                class="bg-gray-400 text-white font-semibold py-3 px-6 rounded-xl flex items-center gap-2 cursor-not-allowed opacity-70">
                            <span class="text-xl">📊</span>
                            Download CSV
                        </button>
                    @endif

                    {{-- Tombol Keluar --}}
                    <form action="{{ route('guru.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-xl transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            🚪 Keluar
                        </button>
                    </form>
                </div>
            </header>

            @if(session('success'))
                @include('components.alert', ['type' => 'success', 'message' => session('success')])
            @endif

            @if(session('error'))
                @include('components.alert', ['type' => 'error', 'message' => session('error')])
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                {{-- Card Total Siswa --}}
                @include('components.statistic-card', [
                    'title' => 'Total Siswa',
                    'value' => $statistics['total_siswa'],
                    'icon' => '👥',
                    'color' => 'blue',
                ])

                {{-- Card Nilai Rata-rata --}}
                @include('components.statistic-card', [
                    'title' => 'Nilai Rata-rata',
                    'value' => number_format($statistics['rata_rata'], 1),
                    'icon' => '📈',
                    'color' => 'green',
                ])

                {{-- Card Lulus (>=60) --}}
                @include('components.statistic-card', [
                    'title' => 'Lulus (≥' . $passingGrade . ')',
                    'value' => $statistics['lulus'],
                    'extra' => '('. number_format($statistics['persentase_lulus'], 0) .'%)',
                    'icon' => '✅',
                    'color' => 'purple',
                ])

                {{-- Card Tidak Lulus --}}
                @include('components.statistic-card', [
                    'title' => 'Tidak Lulus',
                    'value' => $statistics['tidak_lulus'],
                    'icon' => '❌', // Mengganti emoji dari 📚 ke ❌ agar lebih sesuai dengan 'Tidak Lulus'
                    'color' => 'red',
                ])
            </div>

            @if(count($data) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    {{-- Card Nilai Tertinggi --}}
                    <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl shadow-xl p-6 text-white transform transition duration-300 hover:scale-[1.02]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm font-bold uppercase">🏆 Nilai Tertinggi</p>
                                <p class="text-5xl font-extrabold mt-1">{{ number_format($statistics['nilai_tertinggi'], 0) }}</p>
                            </div>
                            <div class="text-7xl opacity-80">⭐</div>
                        </div>
                    </div>

                    {{-- Card Nilai Terendah --}}
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-xl p-6 text-white transform transition duration-300 hover:scale-[1.02]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-bold uppercase">📉 Nilai Terendah</p>
                                <p class="text-5xl font-extrabold mt-1">{{ number_format($statistics['nilai_terendah'], 0) }}</p>
                            </div>
                            <div class="text-7xl opacity-80">📉</div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden ring-1 ring-gray-100">
                <div class="bg-gradient-to-r from-purple-700 to-indigo-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        📋 Data Hasil Kuis Siswa
                        @if(count($data) > 0)
                            <span class="text-base bg-white/20 px-3 py-1 rounded-full font-medium">{{ count($data) }} siswa</span>
                        @endif
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-purple-50 border-b border-purple-200 sticky top-0">
                            <tr>
                                <th class="p-4 text-purple-800 font-extrabold text-sm uppercase tracking-wider">No</th>
                                <th class="p-4 text-purple-800 font-extrabold text-sm uppercase tracking-wider">Tanggal & Waktu</th>
                                <th class="p-4 text-purple-800 font-extrabold text-sm uppercase tracking-wider">Nama Siswa</th>
                                <th class="p-4 text-purple-800 font-extrabold text-sm uppercase tracking-wider">Kelas</th>
                                <th class="p-4 text-purple-800 font-extrabold text-sm uppercase tracking-wider text-center">Absen</th>
                                <th class="p-4 text-purple-800 font-extrabold text-sm uppercase tracking-wider text-center">Benar</th>
                                <th class="p-4 text-purple-800 font-extrabold text-sm uppercase tracking-wider text-center">Salah</th>
                                <th class="p-4 text-purple-800 font-extrabold text-sm uppercase tracking-wider text-center">Nilai</th>
                                <th class="p-4 text-purple-800 font-extrabold text-sm uppercase tracking-wider text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($data as $index => $row)
                                @php
                                    $score = $row['nilai'];
                                    $nilaiClass = '';
                                    $statusEmoji = '';
                                    $statusTitle = '';

                                    if ($score >= 80) {
                                        $nilaiClass = 'bg-green-600 text-white';
                                        $statusEmoji = '🏆';
                                        $statusTitle = 'Sangat Baik';
                                    } elseif ($score >= $passingGrade) {
                                        $nilaiClass = 'bg-yellow-500 text-white';
                                        $statusEmoji = '😊';
                                        $statusTitle = 'Baik';
                                    } else {
                                        $nilaiClass = 'bg-red-500 text-white';
                                        $statusEmoji = '📚';
                                        $statusTitle = 'Perlu Bimbingan';
                                    }
                                @endphp
                                <tr class="hover:bg-purple-50 transition-colors duration-200">
                                    <td class="p-4 text-gray-700 font-medium">{{ $index + 1 }}</td>
                                    <td class="p-4 text-sm text-gray-600 whitespace-nowrap">
                                        <span class="font-medium block">{{ date('d/m/Y', strtotime($row['tanggal'])) }}</span>
                                        <span class="text-xs text-gray-500">{{ date('H:i', strtotime($row['tanggal'])) }} WIB</span>
                                    </td>
                                    <td class="p-4 font-semibold text-gray-800 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg">👤</span>
                                            {{ $row['nama'] }}
                                        </div>
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $row['kelas'] }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center font-bold text-gray-700">{{ $row['absen'] }}</td>
                                    <td class="p-4 text-center whitespace-nowrap">
                                        <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-green-200">
                                            ✓ {{ $row['benar'] }}/{{ $totalQuestions }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center whitespace-nowrap">
                                        <span class="bg-red-50 text-red-700 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-red-200">
                                            ✗ {{ $row['salah'] }}/{{ $totalQuestions }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="px-4 py-2 rounded-lg text-lg font-extrabold min-w-[70px] inline-block shadow-md {{ $nilaiClass }}">
                                            {{ number_format($row['nilai'], 0) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="text-2xl" title="{{ $statusTitle }}">{{ $statusEmoji }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="p-12 text-center bg-gray-50">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="text-7xl opacity-70">📝</div>
                                            <p class="text-gray-500 text-xl font-bold">Belum ada siswa yang mengerjakan kuis.</p>
                                            <p class="text-gray-400 text-base">Data akan muncul setelah siswa menyelesaikan kuis.</p>
                                            <a href="{{ route('kuis.index') }}" class="mt-4 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-md">
                                                Mulai Kuis Siswa
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-10 bg-indigo-50 border-l-4 border-indigo-500 p-6 rounded-xl shadow-md">
                <div class="flex items-start gap-4">
                    <div class="text-4xl text-indigo-600">💡</div>
                    <div>
                        <h3 class="font-bold text-indigo-800 text-xl mb-3">Keterangan Penilaian:</h3>
                        <ul class="text-gray-700 space-y-2">
                            <li><span class="font-extrabold text-2xl mr-2">🏆</span> <strong>80-100:</strong> Sangat Baik - Siswa menguasai materi dengan sangat baik</li>
                            <li><span class="font-extrabold text-2xl mr-2">😊</span> <strong>{{ $passingGrade }}-79:</strong> Baik - Siswa cukup memahami materi (Lulus)</li>
                            <li><span class="font-extrabold text-2xl mr-2">📚</span> <strong>&lt;{{ $passingGrade }}:</strong> Perlu Bimbingan - Siswa perlu review materi lebih dalam (Tidak Lulus)</li>
                        </ul>
                        <div class="mt-5 pt-4 border-t border-indigo-200">
                            <p class="text-sm text-gray-600">
                                <strong>Total Soal:</strong> {{ $totalQuestions }} soal pilihan ganda |
                                <strong>Passing Grade:</strong> {{ $passingGrade }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('landing') }}"
                   class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-xl transition duration-300 shadow-sm hover:shadow-md">
                    <span class="text-xl">←</span> Kembali ke Home
                </a>
            </div>
        </div>
    </div>
@endsection