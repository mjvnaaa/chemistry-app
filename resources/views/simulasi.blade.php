@extends('layout')

@section('title', 'Virtual Lab')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-10 fade-in">
            <a href="{{ route('landing') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 mb-6 font-semibold transition-colors duration-300">
                🏠 Kembali ke Home
            </a>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-4 flex items-center justify-center gap-4">
                <span class="text-6xl">🔬</span>
                Virtual Lab
            </h1>
            <p class="text-gray-600 text-xl max-w-2xl mx-auto">Visualisasikan interaksi molekul, pergerakan partikel, dan pengaruh suhu secara real-time di laboratorium virtual ini.</p>
        </div>

        <div class="grid lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4 fade-in" style="animation-delay: 0.1s;">
                <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border-l-8 border-blue-500 h-full">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                        <span class="text-3xl">🎛️</span>
                        Panel Kontrol
                    </h2>
                    
                    <div class="mb-8">
                        <h3 class="font-bold text-gray-700 mb-4 text-sm uppercase tracking-wider">Pilih Zat:</h3>
                        <div class="grid grid-cols-1 gap-3">
                            <button onclick="selectMolecule('water')" class="molecule-btn group w-full bg-blue-50 hover:bg-blue-100 border-2 border-blue-200 hover:border-blue-400 p-4 rounded-2xl flex items-center gap-4 transition-all duration-300">
                                <div class="text-3xl bg-white rounded-full w-12 h-12 flex items-center justify-center shadow-sm">💧</div>
                                <div class="text-left">
                                    <span class="font-bold text-blue-800 block text-lg">Air (H₂O)</span>
                                    <span class="text-xs text-blue-600 font-medium bg-blue-200 px-2 py-0.5 rounded-full">Ikatan Hidrogen</span>
                                </div>
                            </button>
                            
                            <button onclick="selectMolecule('ammonia')" class="molecule-btn group w-full bg-purple-50 hover:bg-purple-100 border-2 border-purple-200 hover:border-purple-400 p-4 rounded-2xl flex items-center gap-4 transition-all duration-300">
                                <div class="text-3xl bg-white rounded-full w-12 h-12 flex items-center justify-center shadow-sm">☁️</div>
                                <div class="text-left">
                                    <span class="font-bold text-purple-800 block text-lg">Amonia (NH₃)</span>
                                    <span class="text-xs text-purple-600 font-medium bg-purple-200 px-2 py-0.5 rounded-full">Ikatan Hidrogen</span>
                                </div>
                            </button>

                            <button onclick="selectMolecule('methane')" class="molecule-btn group w-full bg-green-50 hover:bg-green-100 border-2 border-green-200 hover:border-green-400 p-4 rounded-2xl flex items-center gap-4 transition-all duration-300">
                                <div class="text-3xl bg-white rounded-full w-12 h-12 flex items-center justify-center shadow-sm">🔥</div>
                                <div class="text-left">
                                    <span class="font-bold text-green-800 block text-lg">Metana (CH₄)</span>
                                    <span class="text-xs text-green-600 font-medium bg-green-200 px-2 py-0.5 rounded-full">Gaya London</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex justify-between items-end mb-2">
                            <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wider">Suhu:</h3>
                            <span id="temp-value" class="font-bold text-2xl text-red-600">25°C</span>
                        </div>
                        <div class="bg-gray-100 rounded-2xl p-4 border border-gray-200">
                            <input type="range" id="temperature-slider" min="-50" max="150" value="25" 
                                   class="w-full h-2 bg-gradient-to-r from-blue-400 via-yellow-400 to-red-500 rounded-lg appearance-none cursor-pointer mb-2"
                                   oninput="updateTemperature(this.value)">
                            <div class="flex justify-between text-xs font-semibold text-gray-500">
                                <span>❄️ Dingin</span>
                                <span>🔥 Panas</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex justify-between items-end mb-2">
                            <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wider">Tekanan:</h3>
                            <span id="pressure-value" class="font-bold text-2xl text-purple-600">1.0 atm</span>
                        </div>
                        <div class="bg-gray-100 rounded-2xl p-4 border border-gray-200">
                            <input type="range" id="pressure-slider" min="0.1" max="10" step="0.1" value="1" 
                                   class="w-full h-2 bg-gradient-to-r from-gray-300 to-purple-500 rounded-lg appearance-none cursor-pointer mb-2"
                                   oninput="updatePressure(this.value)">
                            <div class="flex justify-between text-xs font-semibold text-gray-500">
                                <span>Rendah</span>
                                <span>Tinggi</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button onclick="startSimulation()" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg hover:shadow-green-500/30 flex items-center justify-center gap-2 transform active:scale-95">
                            <span>▶️</span>
                            <span>Mulai</span>
                        </button>
                        <button onclick="resetSimulation()" class="bg-white hover:bg-gray-50 text-gray-700 border-2 border-gray-300 font-bold py-3 px-4 rounded-xl transition shadow hover:shadow-md flex items-center justify-center gap-2 transform active:scale-95">
                            <span>🔄</span>
                            <span>Reset</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 fade-in" style="animation-delay: 0.2s;">
                <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border-l-8 border-purple-500 h-full flex flex-col">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                        <span class="text-3xl">🧪</span>
                        Tampilan Submikroskopik
                    </h2>
                    
                    <div class="relative bg-gradient-to-b from-slate-800 to-slate-900 rounded-2xl overflow-hidden border-4 border-slate-700 shadow-inner flex-grow min-h-[400px]">
                        
                        <div id="simulation-canvas" class="w-full h-full relative">
                            </div>
                        
                        <div class="absolute top-4 left-4 right-4 flex justify-between">
                            <div class="bg-black/50 backdrop-blur-md rounded-lg px-4 py-2 text-white border border-white/10">
                                <span class="text-gray-300 text-xs uppercase tracking-wider block">Status</span>
                                <span id="status-text" class="font-bold text-green-400">Siap</span>
                            </div>
                            <div class="bg-black/50 backdrop-blur-md rounded-lg px-4 py-2 text-white border border-white/10 text-right">
                                <span class="text-gray-300 text-xs uppercase tracking-wider block">Energi Sistem</span>
                                <span id="energy-level" class="font-bold text-yellow-400">0 kJ</span>
                            </div>
                        </div>

                        <div class="absolute bottom-4 left-4">
                             <div class="bg-black/50 backdrop-blur-md rounded-lg px-4 py-2 text-white border border-white/10 flex items-center gap-2">
                                <span class="text-2xl">⚛️</span>
                                <div>
                                    <span class="text-gray-300 text-xs uppercase tracking-wider block">Jumlah Partikel</span>
                                    <span id="molecule-count" class="font-bold text-white">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex flex-wrap gap-4 justify-center bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full bg-blue-500 shadow-sm border border-blue-600"></div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800">H₂O</span>
                                <span class="text-[10px] text-gray-500 uppercase">Ikatan Hidrogen</span>
                            </div>
                        </div>
                        <div class="w-px h-8 bg-gray-300"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full bg-green-500 shadow-sm border border-green-600"></div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800">CH₄</span>
                                <span class="text-[10px] text-gray-500 uppercase">Gaya London</span>
                            </div>
                        </div>
                        <div class="w-px h-8 bg-gray-300"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full bg-purple-500 shadow-sm border border-purple-600"></div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800">NH₃</span>
                                <span class="text-[10px] text-gray-500 uppercase">Ikatan Hidrogen</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border-l-8 border-yellow-500 fade-in" style="animation-delay: 0.3s;">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                <span class="text-3xl">📊</span>
                Analisis Interaksi Molekul
            </h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-2xl border border-blue-100 hover:border-blue-300 transition-colors">
                    <h3 class="font-bold text-blue-800 mb-3 flex items-center gap-2 text-lg">
                        <span class="text-2xl">💧</span>
                        Ikatan Hidrogen (Air)
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Interaksi antarmolekul yang sangat kuat karena adanya atom H yang terikat pada atom elektronegatif (O). Menyebabkan titik didih tinggi (100°C).
                    </p>
                    <div class="inline-block bg-white text-blue-600 text-xs font-bold px-3 py-1 rounded-full border border-blue-200">
                        Kuat & Stabil
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-fuchsia-50 p-6 rounded-2xl border border-purple-100 hover:border-purple-300 transition-colors">
                    <h3 class="font-bold text-purple-800 mb-3 flex items-center gap-2 text-lg">
                        <span class="text-2xl">☁️</span>
                        Ikatan Hidrogen (Amonia)
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Juga memiliki ikatan hidrogen (N-H), namun lebih lemah dibandingkan air. Titik didih lebih rendah (-33°C) tetapi masih relatif tinggi untuk massa molekulnya.
                    </p>
                    <div class="inline-block bg-white text-purple-600 text-xs font-bold px-3 py-1 rounded-full border border-purple-200">
                        Sedang - Kuat
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-2xl border border-green-100 hover:border-green-300 transition-colors">
                    <h3 class="font-bold text-green-800 mb-3 flex items-center gap-2 text-lg">
                        <span class="text-2xl">🔥</span>
                        Gaya London (Metana)
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Hanya memiliki gaya dispersi London yang lemah karena molekul non-polar. Sangat mudah menguap dengan titik didih sangat rendah (-161°C).
                    </p>
                    <div class="inline-block bg-white text-green-600 text-xs font-bold px-3 py-1 rounded-full border border-green-200">
                        Lemah & Mudah Lepas
                    </div>
                </div>
            </div>
        </div>

<div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 fade-in" style="animation-delay: 0.4s;">
    <a href="{{ route('simulasi.molekul') }}" 
       class="group relative bg-gradient-to-r from-pink-600 to-rose-600 text-white py-6 px-8 rounded-2xl text-center font-bold text-xl hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
        <div class="absolute inset-0 bg-gradient-to-r from-pink-700 to-rose-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10 flex flex-col items-center justify-center gap-3">
            <span class="text-5xl">🧬</span>
            <div>
                <div class="text-lg font-semibold opacity-90">Mode Dasar</div>
                <div class="text-xl">Simulasi Molekul</div>
            </div>
        </div>
    </a>

    <a href="{{ route('materi') }}" 
       class="group relative bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-6 px-8 rounded-2xl text-center font-bold text-xl hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10 flex flex-col items-center justify-center gap-3">
            <span class="text-5xl">📖</span>
            <div>
                <div class="text-lg font-semibold opacity-90">Kembali ke</div>
                <div class="text-xl">Review Materi</div>
            </div>
        </div>
    </a>

    <a href="{{ route('kuis.index') }}" 
       class="group relative bg-gradient-to-r from-orange-600 to-red-600 text-white py-6 px-8 rounded-2xl text-center font-bold text-xl hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-700 to-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10 flex flex-col items-center justify-center gap-3">
            <span class="text-5xl">📝</span>
            <div>
                <div class="text-lg font-semibold opacity-90">Tes di</div>
                <div class="text-xl">Kuis Interaktif</div>
            </div>
        </div>
    </a>
</div>

<script>
// Variabel simulasi
let simulationRunning = false;
let selectedMolecule = 'water';
let temperature = 25;
let pressure = 1.0;
let molecules = [];
let animationId = null;

// Warna untuk setiap jenis molekul
const moleculeColors = {
    'water': '#3b82f6',    // Biru
    'methane': '#22c55e',  // Hijau
    'ammonia': '#8b5cf6'   // Ungu
};

// Sifat molekul
const moleculeProperties = {
    'water': {
        name: 'H₂O',
        size: 20,
        speed: 1.0,
        interaction: 'hydrogen',
        boilingPoint: 100
    },
    'methane': {
        name: 'CH₄',
        size: 25,
        speed: 1.5,
        interaction: 'london',
        boilingPoint: -161
    },
    'ammonia': {
        name: 'NH₃',
        size: 22,
        speed: 1.2,
        interaction: 'hydrogen',
        boilingPoint: -33
    }
};

// Pilih molekul
function selectMolecule(type) {
    selectedMolecule = type;
    
    // Update button styles
    document.querySelectorAll('.molecule-btn').forEach(btn => {
        btn.classList.remove('border-blue-500', 'bg-blue-50', 'shadow-md');
        btn.classList.add('border-gray-200', 'bg-white');
    });
    
    // Highlight selected button
    const selectedBtn = event.currentTarget;
    selectedBtn.classList.remove('border-gray-200', 'bg-white');
    
    // Apply specific color based on type
    if(type === 'water') selectedBtn.classList.add('border-blue-500', 'bg-blue-50', 'shadow-md');
    if(type === 'ammonia') selectedBtn.classList.add('border-purple-500', 'bg-purple-50', 'shadow-md');
    if(type === 'methane') selectedBtn.classList.add('border-green-500', 'bg-green-50', 'shadow-md');
    
    // Update status
    document.getElementById('status-text').textContent = `Molekul: ${moleculeProperties[type].name}`;
    resetSimulation();
}

// Update suhu
function updateTemperature(value) {
    temperature = parseInt(value);
    document.getElementById('temp-value').textContent = `${temperature}°C`;
    
    // Update warna berdasarkan suhu
    let color;
    if (temperature < 0) color = 'text-blue-600';
    else if (temperature < 100) color = 'text-green-600';
    else color = 'text-red-600';
    document.getElementById('temp-value').className = `font-bold text-2xl ${color}`;
    
    // Update kecepatan molekul jika simulasi berjalan
    if (simulationRunning) {
        updateMoleculeSpeeds();
    }
}

// Update tekanan
function updatePressure(value) {
    pressure = parseFloat(value);
    document.getElementById('pressure-value').textContent = `${pressure.toFixed(1)} atm`;
}

// Update kecepatan molekul berdasarkan suhu
function updateMoleculeSpeeds() {
    const baseSpeed = moleculeProperties[selectedMolecule].speed;
    // Faktor kecepatan meningkat dengan suhu (termal energi)
    const thermalFactor = Math.max(0.2, (temperature + 273) / 298); 
    
    molecules.forEach(mol => {
        // Arah random, magnitudo berdasarkan suhu
        const angle = Math.random() * Math.PI * 2;
        mol.vx = Math.cos(angle) * baseSpeed * thermalFactor;
        mol.vy = Math.sin(angle) * baseSpeed * thermalFactor;
    });
}

// Mulai simulasi
function startSimulation() {
    if (simulationRunning) return;
    
    simulationRunning = true;
    document.getElementById('status-text').textContent = 'Berjalan';
    document.getElementById('status-text').className = 'font-bold text-green-400';
    
    // Buat 30 molekul (sedikit lebih banyak untuk virtual lab)
    const canvas = document.getElementById('simulation-canvas');
    molecules = [];
    
    for (let i = 0; i < 30; i++) {
        molecules.push({
            id: i,
            type: selectedMolecule,
            x: Math.random() * (canvas.clientWidth - 40) + 20,
            y: Math.random() * (canvas.clientHeight - 40) + 20,
            vx: (Math.random() - 0.5) * 2,
            vy: (Math.random() - 0.5) * 2,
            size: moleculeProperties[selectedMolecule].size,
            color: moleculeColors[selectedMolecule]
        });
    }
    
    // Apply initial temperature effect
    updateMoleculeSpeeds();
    
    document.getElementById('molecule-count').textContent = molecules.length;
    updateEnergyLevel();
    
    // Mulai animasi
    animate();
}

// Animasi
function animate() {
    if (!simulationRunning) return;
    
    const canvas = document.getElementById('simulation-canvas');
    canvas.innerHTML = ''; // Clear canvas
    
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    
    // Update dan gambar setiap molekul
    molecules.forEach(mol => {
        // Update posisi
        mol.x += mol.vx;
        mol.y += mol.vy;
        
        // Pantulan dari dinding
        if (mol.x <= 0) { mol.x = 0; mol.vx *= -1; }
        if (mol.x >= width - mol.size) { mol.x = width - mol.size; mol.vx *= -1; }
        if (mol.y <= 0) { mol.y = 0; mol.vy *= -1; }
        if (mol.y >= height - mol.size) { mol.y = height - mol.size; mol.vy *= -1; }
        
        // Gambar molekul (DOM element untuk performa lebih baik di simple demo)
        const div = document.createElement('div');
        div.style.position = 'absolute';
        div.style.left = `${mol.x}px`;
        div.style.top = `${mol.y}px`;
        div.style.width = `${mol.size}px`;
        div.style.height = `${mol.size}px`;
        div.style.backgroundColor = mol.color;
        div.style.borderRadius = '50%';
        div.style.boxShadow = 'inset -2px -2px 6px rgba(0,0,0,0.3), 1px 1px 3px rgba(0,0,0,0.5)'; // 3D effect
        div.style.transition = 'background-color 0.3s';
        
        // Simbol elemen pada molekul (opsional, untuk visual lebih bagus)
        if (mol.size > 20) {
             div.innerHTML = `<span style="display:flex; justify-content:center; align-items:center; height:100%; color:rgba(255,255,255,0.8); font-size:10px; font-weight:bold;">${moleculeProperties[mol.type].name.charAt(0)}</span>`;
        }

        canvas.appendChild(div);
    });
    
    // Deteksi interaksi (gambar garis antara molekul yang dekat)
    drawInteractions();
    
    animationId = requestAnimationFrame(animate);
}

// Gambar interaksi
function drawInteractions() {
    const canvas = document.getElementById('simulation-canvas');
    const interactionRange = 60; // Jarak interaksi
    
    for (let i = 0; i < molecules.length; i++) {
        for (let j = i + 1; j < molecules.length; j++) {
            const dx = molecules[i].x - molecules[j].x;
            const dy = molecules[i].y - molecules[j].y;
            const distance = Math.sqrt(dx * dx + dy * dy);
            
            if (distance < interactionRange) {
                // Buat garis
                const line = document.createElement('div');
                line.style.position = 'absolute';
                line.style.left = `${molecules[i].x + molecules[i].size/2}px`;
                line.style.top = `${molecules[i].y + molecules[i].size/2}px`;
                line.style.width = `${distance}px`;
                line.style.height = '1px';
                line.style.backgroundColor = 'rgba(255, 255, 255, 0.4)';
                line.style.transformOrigin = '0 0';
                line.style.transform = `rotate(${Math.atan2(dy, dx)}rad)`;
                line.style.zIndex = '0'; // Di belakang molekul
                
                canvas.insertBefore(line, canvas.firstChild);
            }
        }
    }
}

// Update level energi
function updateEnergyLevel() {
    // Estimasi energi kinetik total ~ T * jumlah molekul
    const energy = molecules.length * (temperature + 273) * 0.01; 
    document.getElementById('energy-level').textContent = `${energy.toFixed(1)} kJ`;
}

// Reset simulasi
function resetSimulation() {
    simulationRunning = false;
    if (animationId) {
        cancelAnimationFrame(animationId);
    }
    
    const canvas = document.getElementById('simulation-canvas');
    canvas.innerHTML = '';
    
    molecules = [];
    
    document.getElementById('status-text').textContent = 'Siap';
    document.getElementById('status-text').className = 'font-bold text-green-400';
    document.getElementById('molecule-count').textContent = '0';
    document.getElementById('energy-level').textContent = '0 kJ';
    
    // Reset to default selection UI
    selectMolecule(selectedMolecule);
}

// Inisialisasi
document.addEventListener('DOMContentLoaded', function() {
    // Select default molecule visual state
    selectMolecule('water');
});
</script>

<style>
/* Animation for active molecule buttons */
@keyframes pulse-ring {
    0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
    70% { box-shadow: 0 0 0 6px rgba(59, 130, 246, 0); }
    100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
}

.molecule-btn:focus {
    outline: none;
}
</style>
@endsection