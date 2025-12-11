@extends('layout')

@section('title', 'Dashboard Guru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Dashboard -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                    <span class="text-4xl mr-3">👨‍🏫</span>
                    Dashboard Guru
                </h1>
                <p class="text-gray-600 mt-1">Monitoring Hasil Kuis Siswa - Gaya Antar Molekul</p>
                @if(Session::has('guru_login_time'))
                    <p class="text-sm text-gray-500 mt-1">
                        Login: {{ Session::get('guru_login_time')->format('d/m/Y H:i') }} WIB
                    </p>
                @endif
            </div>
            <div class="flex gap-3">
                @if(count($data) > 0)
                <a href="{{ route('guru.export') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span class="text-xl">📊</span>
                    Download CSV
                </a>
                @else
                <button disabled 
                        class="bg-gray-400 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2 cursor-not-allowed opacity-50">
                    <span class="text-xl">📊</span>
                    Download CSV
                </button>
                @endif
                
                <form action="{{ route('guru.logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        🚪 Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
            <div class="flex items-center gap-2">
                <span class="text-xl">✅</span>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
            <div class="flex items-center gap-2">
                <span class="text-xl">❌</span>
                <p class="font-semibold">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Statistik Card -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase">Total Siswa</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $statistics['total_siswa'] }}</p>
                    </div>
                    <div class="text-5xl">👥</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase">Nilai Rata-rata</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($statistics['rata_rata'], 1) }}</p>
                    </div>
                    <div class="text-5xl">📈</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase">Lulus (≥60)</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            {{ $statistics['lulus'] }}
                            <span class="text-lg text-gray-600">({{ number_format($statistics['persentase_lulus'], 0) }}%)</span>
                        </p>
                    </div>
                    <div class="text-5xl">✅</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase">Tidak Lulus</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $statistics['tidak_lulus'] }}</p>
                    </div>
                    <div class="text-5xl">📚</div>
                </div>
            </div>
        </div>

        <!-- Nilai Tertinggi & Terendah -->
        @if(count($data) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-semibold uppercase">🏆 Nilai Tertinggi</p>
                        <p class="text-4xl font-bold mt-1">{{ number_format($statistics['nilai_tertinggi'], 0) }}</p>
                    </div>
                    <div class="text-6xl">⭐</div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-400 to-indigo-500 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-semibold uppercase">📊 Nilai Terendah</p>
                        <p class="text-4xl font-bold mt-1">{{ number_format($statistics['nilai_terendah'], 0) }}</p>
                    </div>
                    <div class="text-6xl">📉</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tabel Data Siswa -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    📋 Data Hasil Kuis Siswa
                    @if(count($data) > 0)
                        <span class="text-sm bg-white/20 px-3 py-1 rounded-full">{{ count($data) }} siswa</span>
                    @endif
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-purple-100 border-b-2 border-purple-200">
                        <tr>
                            <th class="p-4 text-purple-800 font-bold">No</th>
                            <th class="p-4 text-purple-800 font-bold">Tanggal & Waktu</th>
                            <th class="p-4 text-purple-800 font-bold">Nama Siswa</th>
                            <th class="p-4 text-purple-800 font-bold">Kelas</th>
                            <th class="p-4 text-purple-800 font-bold text-center">Absen</th>
                            <th class="p-4 text-purple-800 font-bold text-center">Benar</th>
                            <th class="p-4 text-purple-800 font-bold text-center">Salah</th>
                            <th class="p-4 text-purple-800 font-bold text-center">Nilai</th>
                            <th class="p-4 text-purple-800 font-bold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($data as $index => $row)
                        <tr class="hover:bg-purple-50 transition-colors duration-200">
                            <td class="p-4 text-gray-700 font-semibold">{{ $index + 1 }}</td>
                            <td class="p-4 text-sm text-gray-600">
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ date('d/m/Y', strtotime($row['tanggal'])) }}</span>
                                    <span class="text-xs text-gray-500">{{ date('H:i', strtotime($row['tanggal'])) }} WIB</span>
                                </div>
                            </td>
                            <td class="p-4 font-semibold text-gray-800">
                                <div class="flex items-center gap-2">
                                    <span class="text-xl">👤</span>
                                    {{ $row['nama'] }}
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $row['kelas'] }}
                                </span>
                            </td>
                            <td class="p-4 text-center font-bold text-gray-700">{{ $row['absen'] }}</td>
                            <td class="p-4 text-center">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold">
                                    ✓ {{ $row['benar'] }}/15
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-bold">
                                    ✗ {{ $row['salah'] }}/15
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-4 py-2 rounded-lg text-lg font-bold 
                                    {{ $row['nilai'] >= 80 ? 'bg-green-500 text-white' : ($row['nilai'] >= 60 ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }}">
                                    {{ number_format($row['nilai'], 0) }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                @if($row['nilai'] >= 80)
                                    <span class="text-2xl" title="Sangat Baik">🏆</span>
                                @elseif($row['nilai'] >= 60)
                                    <span class="text-2xl" title="Baik">😊</span>
                                @else
                                    <span class="text-2xl" title="Perlu Bimbingan">📚</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="p-12 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="text-7xl">📝</div>
                                    <p class="text-gray-500 text-lg font-semibold">Belum ada siswa yang mengerjakan kuis.</p>
                                    <p class="text-gray-400 text-sm">Data akan muncul setelah siswa menyelesaikan kuis.</p>
                                    <a href="{{ route('kuis') }}" class="mt-4 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg transition">
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

        <!-- Footer Info -->
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
            <div class="flex items-start gap-3">
                <div class="text-3xl">💡</div>
                <div>
                    <h3 class="font-bold text-blue-800 text-lg mb-2">Keterangan Penilaian:</h3>
                    <ul class="text-gray-700 space-y-1">
                        <li>🏆 <strong>80-100:</strong> Sangat Baik - Siswa menguasai materi dengan sangat baik</li>
                        <li>😊 <strong>60-79:</strong> Baik - Siswa cukup memahami materi (Lulus)</li>
                        <li>📚 <strong>&lt;60:</strong> Perlu Bimbingan - Siswa perlu review materi lebih dalam (Tidak Lulus)</li>
                    </ul>
                    <div class="mt-4 pt-4 border-t border-blue-200">
                        <p class="text-sm text-gray-600">
                            <strong>Total Soal:</strong> 15 soal pilihan ganda | 
                            <strong>Passing Grade:</strong> 60
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-8 text-center">
            <a href="{{ route('landing') }}" 
               class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
                ← Kembali ke Home
            </a>
        </div>
    </div>
</div>
@endsection