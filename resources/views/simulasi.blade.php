@extends('layout')

@section('title', 'Simulasi Interaktif')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 mb-6 font-semibold">
                ← Kembali ke Home
            </a>
            <h1 class="text-4xl font-bold text-gray-800 mb-3 flex items-center justify-center gap-3">
                <span class="text-5xl">🔬</span>
                Simulasi Interaktif Molekul
            </h1>
            <p class="text-gray-600 text-lg">Amati bagaimana suhu dan tekanan mempengaruhi interaksi antar molekul</p>
        </div>

        <!-- Simulasi Container -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <span class="text-2xl">🧪</span>
                    PhET Interactive Simulation - States of Matter
                </h2>
            </div>
            
            <div class="p-4">
                <div class="bg-gray-900 rounded-xl overflow-hidden" style="height: 600px;">
                    <iframe 
                        src="https://phet.colorado.edu/sims/html/states-of-matter-basics/latest/states-of-matter-basics_in.html" 
                        width="100%" 
                        height="100%" 
                        allowfullscreen
                        class="border-0">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Panduan Penggunaan -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <!-- Panduan -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                <h3 class="font-bold text-purple-800 text-xl mb-4 flex items-center gap-2">
                    <span class="text-2xl">📖</span>
                    Panduan Simulasi
                </h3>
                <ol class="list-decimal list-inside space-y-3 text-gray-700">
                    <li class="flex items-start gap-2">
                        <span class="font-bold text-purple-600">1.</span>
                        <span>Pilih tab <strong>"States"</strong> atau <strong>"Phase Changes"</strong> di atas</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold text-purple-600">2.</span>
                        <span>Pilih molekul: <strong>Neon, Argon, Oxygen, atau Water</strong> (perhatikan perbedaannya!)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold text-purple-600">3.</span>
                        <span>Geser slider <strong>"Heat/Cool"</strong> untuk mengubah suhu</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold text-purple-600">4.</span>
                        <span>Amati perubahan kecepatan dan jarak antar molekul</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold text-purple-600">5.</span>
                        <span>Perhatikan bagaimana molekul berubah dari <strong>Padat → Cair → Gas</strong></span>
                    </li>
                </ol>
            </div>

            <!-- Konsep Yang Dipelajari -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <h3 class="font-bold text-blue-800 text-xl mb-4 flex items-center gap-2">
                    <span class="text-2xl">💡</span>
                    Yang Perlu Diamati
                </h3>
                <div class="space-y-4 text-gray-700">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-bold text-blue-700 mb-2">🧊 Wujud Padat (Solid)</h4>
                        <p class="text-sm">Molekul bergerak lambat, gaya antar molekul <strong>sangat kuat</strong>, posisi tetap (hanya bergetar)</p>
                    </div>
                    
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h4 class="font-bold text-purple-700 mb-2">💧 Wujud Cair (Liquid)</h4>
                        <p class="text-sm">Molekul bergerak lebih cepat, gaya antar molekul <strong>sedang</strong>, dapat bergeser tapi masih rapat</p>
                    </div>
                    
                    <div class="bg-pink-50 p-4 rounded-lg">
                        <h4 class="font-bold text-pink-700 mb-2">💨 Wujud Gas (Gas)</h4>
                        <p class="text-sm">Molekul bergerak sangat cepat, gaya antar molekul <strong>sangat lemah</strong>, bebas bergerak kemana-mana</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Eksperimen Coba Sendiri -->
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl shadow-lg p-6 mb-8 border-2 border-yellow-300">
            <h3 class="font-bold text-orange-800 text-xl mb-4 flex items-center gap-2">
                <span class="text-3xl">🔥</span>
                Eksperimen Coba Sendiri!
            </h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h4 class="font-bold text-gray-800 mb-2">🧪 Eksperimen 1: Bandingkan Neon vs Water</h4>
                    <p class="text-sm text-gray-700">Mana yang lebih cepat mencair saat dipanaskan? Kenapa?</p>
                    <p class="text-xs text-gray-500 mt-2"><strong>Jawaban:</strong> Neon mencair lebih cepat karena hanya punya Gaya London (lemah), sedangkan Water punya Ikatan Hidrogen (kuat)</p>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow">
                    <h4 class="font-bold text-gray-800 mb-2">❄️ Eksperimen 2: Bekukan Air</h4>
                    <p class="text-sm text-gray-700">Set suhu ke titik terendah. Amati bagaimana molekul air membentuk struktur kristal es!</p>
                    <p class="text-xs text-gray-500 mt-2"><strong>Tip:</strong> Ini menunjukkan ikatan hidrogen yang teratur di es</p>
                </div>
            </div>
        </div>

        <!-- Hubungan dengan Materi -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="font-bold text-gray-800 text-xl mb-4 flex items-center gap-2">
                <span class="text-2xl">🔗</span>
                Hubungan dengan Materi yang Dipelajari
            </h3>
            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-pink-50 to-red-50 p-4 rounded-lg border border-pink-200">
                    <h4 class="font-bold text-red-700 mb-2">Gaya London</h4>
                    <p class="text-sm text-gray-700">Terjadi pada Neon & Argon (molekul non-polar). Gaya terlemah, mudah menguap.</p>
                </div>
                
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-lg border border-blue-200">
                    <h4 class="font-bold text-blue-700 mb-2">Dipol-Dipol</h4>
                    <p class="text-sm text-gray-700">Terjadi pada Oxygen (molekul polar). Gaya sedang, titik didih lebih tinggi dari Neon.</p>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-4 rounded-lg border border-purple-200">
                    <h4 class="font-bold text-purple-700 mb-2">Ikatan Hidrogen</h4>
                    <p class="text-sm text-gray-700">Terjadi pada Water (H₂O). Gaya terkuat, butuh suhu tinggi untuk mendidih.</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center space-y-4">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-400 rounded-xl p-6 inline-block">
                <p class="text-green-800 font-semibold text-lg mb-3">✅ Sudah Paham dengan Simulasi?</p>
                <div class="flex gap-3 justify-center">
                    <a href="{{ route('materi') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        📚 Review Materi Lagi
                    </a>
                    <a href="{{ route('kuis.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        🎯 Lanjut ke Kuis →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection