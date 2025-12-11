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
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4 flex items-center justify-center gap-3">
                <span class="text-5xl">🔬</span>
                Simulasi Interaktif
            </h1>
            <p class="text-gray-600 text-lg">Visualisasikan interaksi molekul dan pengaruh suhu secara real-time!</p>
        </div>

        <!-- Konten Simulasi Alternatif -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Panel Kontrol -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                    <span class="text-3xl">🎛️</span>
                    Kontrol Simulasi
                </h2>
                
                <!-- Jenis Molekul -->
                <div class="mb-6">
                    <h3 class="font-bold text-gray-700 mb-3">Pilih Jenis Molekul:</h3>
                    <div class="grid grid-cols-3 gap-3">
                        <button onclick="selectMolecule('water')" class="molecule-btn bg-blue-100 border-2 border-blue-300 p-4 rounded-xl text-center hover:bg-blue-200 transition active:scale-95">
                            <div class="text-3xl mb-2">💧</div>
                            <span class="font-bold text-blue-700">H₂O</span>
                            <p class="text-xs mt-1 text-blue-600">Ikatan Hidrogen</p>
                        </button>
                        <button onclick="selectMolecule('methane')" class="molecule-btn bg-green-100 border-2 border-green-300 p-4 rounded-xl text-center hover:bg-green-200 transition active:scale-95">
                            <div class="text-3xl mb-2">🔥</div>
                            <span class="font-bold text-green-700">CH₄</span>
                            <p class="text-xs mt-1 text-green-600">Gaya London</p>
                        </button>
                        <button onclick="selectMolecule('ammonia')" class="molecule-btn bg-purple-100 border-2 border-purple-300 p-4 rounded-xl text-center hover:bg-purple-200 transition active:scale-95">
                            <div class="text-3xl mb-2">☁️</div>
                            <span class="font-bold text-purple-700">NH₃</span>
                            <p class="text-xs mt-1 text-purple-600">Ikatan Hidrogen</p>
                        </button>
                    </div>
                </div>

                <!-- Kontrol Suhu -->
                <div class="mb-6">
                    <h3 class="font-bold text-gray-700 mb-3">Kontrol Suhu:</h3>
                    <div class="bg-gray-100 rounded-xl p-4">
                        <div class="flex justify-between mb-2">
                            <span class="font-bold text-blue-600">-50°C</span>
                            <span id="temp-value" class="font-bold text-xl text-red-600">25°C</span>
                            <span class="font-bold text-red-600">150°C</span>
                        </div>
                        <input type="range" id="temperature-slider" min="-50" max="150" value="25" 
                               class="w-full h-3 bg-gradient-to-r from-blue-500 via-green-500 to-red-500 rounded-lg appearance-none cursor-pointer"
                               oninput="updateTemperature(this.value)">
                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                            <span>Padat</span>
                            <span>Cair</span>
                            <span>Gas</span>
                        </div>
                    </div>
                </div>

                <!-- Kontrol Tekanan -->
                <div class="mb-6">
                    <h3 class="font-bold text-gray-700 mb-3">Kontrol Tekanan:</h3>
                    <div class="bg-gray-100 rounded-xl p-4">
                        <div class="flex justify-between mb-2">
                            <span class="font-bold text-gray-600">0.1 atm</span>
                            <span id="pressure-value" class="font-bold text-xl text-purple-600">1.0 atm</span>
                            <span class="font-bold text-gray-600">10.0 atm</span>
                        </div>
                        <input type="range" id="pressure-slider" min="0.1" max="10" step="0.1" value="1" 
                               class="w-full h-3 bg-gradient-to-r from-gray-400 to-purple-600 rounded-lg appearance-none cursor-pointer"
                               oninput="updatePressure(this.value)">
                    </div>
                </div>

                <!-- Aksi -->
                <div class="grid grid-cols-2 gap-3">
                    <button onclick="startSimulation()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2">
                        <span>▶️</span>
                        <span>Mulai</span>
                    </button>
                    <button onclick="resetSimulation()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2">
                        <span>🔄</span>
                        <span>Reset</span>
                    </button>
                </div>
            </div>

            <!-- Area Simulasi -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                    <span class="text-3xl">🧪</span>
                    Area Simulasi
                </h2>
                
                <div class="relative bg-gradient-to-b from-blue-50 to-gray-100 rounded-xl overflow-hidden border-2 border-gray-300" 
                     style="height: 400px;">
                    
                    <!-- Canvas untuk simulasi -->
                    <div id="simulation-canvas" class="w-full h-full relative">
                        <!-- Molekul akan digambar di sini oleh JavaScript -->
                    </div>
                    
                    <!-- Info Status -->
                    <div class="absolute bottom-4 left-4 right-4">
                        <div class="bg-white/90 backdrop-blur-sm rounded-lg p-3 shadow-lg">
                            <div class="flex justify-between">
                                <div>
                                    <span class="font-bold text-gray-700">Status:</span>
                                    <span id="status-text" class="ml-2 font-bold text-green-600">Siap</span>
                                </div>
                                <div>
                                    <span class="font-bold text-gray-700">Molekul:</span>
                                    <span id="molecule-count" class="ml-2 font-bold text-blue-600">0</span>
                                </div>
                                <div>
                                    <span class="font-bold text-gray-700">Energi:</span>
                                    <span id="energy-level" class="ml-2 font-bold text-red-600">0 kJ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="mt-6 grid grid-cols-3 gap-3">
                    <div class="flex items-center gap-2 bg-blue-50 p-3 rounded-lg">
                        <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                        <span class="text-sm font-bold">H₂O</span>
                        <span class="text-xs text-gray-600 ml-auto">Ikatan Hidrogen</span>
                    </div>
                    <div class="flex items-center gap-2 bg-green-50 p-3 rounded-lg">
                        <div class="w-4 h-4 rounded-full bg-green-500"></div>
                        <span class="text-sm font-bold">CH₄</span>
                        <span class="text-xs text-gray-600 ml-auto">Gaya London</span>
                    </div>
                    <div class="flex items-center gap-2 bg-purple-50 p-3 rounded-lg">
                        <div class="w-4 h-4 rounded-full bg-purple-500"></div>
                        <span class="text-sm font-bold">NH₃</span>
                        <span class="text-xs text-gray-600 ml-auto">Ikatan Hidrogen</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penjelasan Interaksi -->
        <div class="mt-8 bg-white rounded-2xl shadow-xl p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                <span class="text-3xl">📊</span>
                Analisis Interaksi Molekul
            </h2>
            
            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl">
                    <h3 class="font-bold text-blue-700 mb-2 flex items-center gap-2">
                        <span>🔵</span>
                        Gaya London
                    </h3>
                    <p class="text-sm text-gray-700">Terlemah, terjadi pada semua molekul non-polar. Semakin besar massa molekul, semakin kuat gayanya.</p>
                    <div class="mt-2">
                        <span class="text-xs font-bold bg-blue-200 text-blue-800 px-2 py-1 rounded">Contoh: CH₄, CO₂</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-4 rounded-xl">
                    <h3 class="font-bold text-yellow-700 mb-2 flex items-center gap-2">
                        <span>🟡</span>
                        Dipol-Dipol
                    </h3>
                    <p class="text-sm text-gray-700">Sedang, terjadi antara molekul polar. Ujung positif dan negatif saling menarik.</p>
                    <div class="mt-2">
                        <span class="text-xs font-bold bg-yellow-200 text-yellow-800 px-2 py-1 rounded">Contoh: HCl, SO₂</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl">
                    <h3 class="font-bold text-green-700 mb-2 flex items-center gap-2">
                        <span>🟢</span>
                        Ikatan Hidrogen
                    </h3>
                    <p class="text-sm text-gray-700">Terkuat, terjadi ketika H terikat pada F, O, atau N. Memengaruhi titik didih secara signifikan.</p>
                    <div class="mt-2">
                        <span class="text-xs font-bold bg-green-200 text-green-800 px-2 py-1 rounded">Contoh: H₂O, HF, NH₃</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <a href="{{ route('simulasi.molekul') }}"
               class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition text-center">
                <span class="flex items-center justify-center gap-2">
                    <span>🧬</span>
                    <span>Simulasi Molekul Interaktif</span>
                </span>
            </a>
            <a href="{{ route('materi') }}"
               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition text-center">
                <span class="flex items-center justify-center gap-2">
                    <span>📖</span>
                    <span>Review Materi</span>
                </span>
            </a>
            <a href="{{ route('kuis.index') }}"
               class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl transition text-center">
                <span class="flex items-center justify-center gap-2">
                    <span>📝</span>
                    <span>Mulai Kuis</span>
                </span>
            </a>
        </div>
    </div>
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
        btn.classList.remove('border-4', 'scale-105');
    });
    event.currentTarget.classList.add('border-4', 'scale-105');
    
    // Update status
    document.getElementById('status-text').textContent = `Molekul: ${moleculeProperties[type].name}`;
    document.getElementById('status-text').className = 'ml-2 font-bold text-blue-600';
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
    document.getElementById('temp-value').className = `font-bold text-xl ${color}`;
    
    // Update kecepatan molekul
    updateMoleculeSpeeds();
}

// Update tekanan
function updatePressure(value) {
    pressure = parseFloat(value);
    document.getElementById('pressure-value').textContent = `${pressure.toFixed(1)} atm`;
}

// Update kecepatan molekul berdasarkan suhu
function updateMoleculeSpeeds() {
    const speedFactor = temperature / 25; // Normalisasi ke suhu ruang
    molecules.forEach(mol => {
        mol.speed = moleculeProperties[mol.type].speed * speedFactor;
    });
}

// Mulai simulasi
function startSimulation() {
    if (simulationRunning) return;
    
    simulationRunning = true;
    document.getElementById('status-text').textContent = 'Berjalan';
    document.getElementById('status-text').className = 'ml-2 font-bold text-green-600';
    
    // Buat 20 molekul
    const canvas = document.getElementById('simulation-canvas');
    molecules = [];
    
    for (let i = 0; i < 20; i++) {
        molecules.push({
            id: i,
            type: selectedMolecule,
            x: Math.random() * (canvas.clientWidth - 40),
            y: Math.random() * (canvas.clientHeight - 40),
            vx: (Math.random() - 0.5) * moleculeProperties[selectedMolecule].speed,
            vy: (Math.random() - 0.5) * moleculeProperties[selectedMolecule].speed,
            size: moleculeProperties[selectedMolecule].size,
            color: moleculeColors[selectedMolecule]
        });
    }
    
    document.getElementById('molecule-count').textContent = molecules.length;
    updateEnergyLevel();
    
    // Mulai animasi
    animate();
}

// Animasi
function animate() {
    if (!simulationRunning) return;
    
    const canvas = document.getElementById('simulation-canvas');
    canvas.innerHTML = '';
    
    // Update dan gambar setiap molekul
    molecules.forEach(mol => {
        // Update posisi
        mol.x += mol.vx * (temperature / 25);
        mol.y += mol.vy * (temperature / 25);
        
        // Pantulan dari dinding
        if (mol.x <= 0 || mol.x >= canvas.clientWidth - mol.size) mol.vx *= -1;
        if (mol.y <= 0 || mol.y >= canvas.clientHeight - mol.size) mol.vy *= -1;
        
        // Gambar molekul
        const div = document.createElement('div');
        div.style.position = 'absolute';
        div.style.left = `${mol.x}px`;
        div.style.top = `${mol.y}px`;
        div.style.width = `${mol.size}px`;
        div.style.height = `${mol.size}px`;
        div.style.backgroundColor = mol.color;
        div.style.borderRadius = '50%';
        div.style.opacity = '0.8';
        div.style.boxShadow = '0 0 10px rgba(0,0,0,0.3)';
        canvas.appendChild(div);
        
        // Gambar label untuk beberapa molekul
        if (mol.id % 5 === 0) {
            const label = document.createElement('div');
            label.style.position = 'absolute';
            label.style.left = `${mol.x + mol.size/2 - 10}px`;
            label.style.top = `${mol.y + mol.size + 5}px`;
            label.style.color = 'white';
            label.style.fontSize = '10px';
            label.style.fontWeight = 'bold';
            label.style.textShadow = '1px 1px 2px rgba(0,0,0,0.5)';
            label.textContent = moleculeProperties[mol.type].name;
            canvas.appendChild(label);
        }
    });
    
    // Deteksi interaksi (gambar garis antara molekul yang dekat)
    drawInteractions();
    
    animationId = requestAnimationFrame(animate);
}

// Gambar interaksi
function drawInteractions() {
    const canvas = document.getElementById('simulation-canvas');
    
    for (let i = 0; i < molecules.length; i++) {
        for (let j = i + 1; j < molecules.length; j++) {
            const dx = molecules[i].x - molecules[j].x;
            const dy = molecules[i].y - molecules[j].y;
            const distance = Math.sqrt(dx * dx + dy * dy);
            
            if (distance < 80) { // Jarak interaksi
                const line = document.createElement('div');
                line.style.position = 'absolute';
                line.style.left = `${molecules[i].x + molecules[i].size/2}px`;
                line.style.top = `${molecules[i].y + molecules[i].size/2}px`;
                line.style.width = `${distance}px`;
                line.style.height = '2px';
                line.style.backgroundColor = getInteractionColor(molecules[i].type, molecules[j].type);
                line.style.opacity = '0.5';
                line.style.transformOrigin = '0 0';
                line.style.transform = `rotate(${Math.atan2(dy, dx)}rad)`;
                canvas.appendChild(line);
            }
        }
    }
}

// Warna interaksi berdasarkan jenis molekul
function getInteractionColor(type1, type2) {
    const props1 = moleculeProperties[type1];
    const props2 = moleculeProperties[type2];
    
    if (props1.interaction === 'hydrogen' && props2.interaction === 'hydrogen') {
        return '#10b981'; // Hijau untuk ikatan hidrogen
    } else if (props1.interaction === 'london' && props2.interaction === 'london') {
        return '#ef4444'; // Merah untuk gaya London
    } else {
        return '#f59e0b'; // Kuning untuk campuran
    }
}

// Update level energi
function updateEnergyLevel() {
    const energy = molecules.length * temperature * 0.1;
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
    document.getElementById('status-text').className = 'ml-2 font-bold text-green-600';
    document.getElementById('molecule-count').textContent = '0';
    document.getElementById('energy-level').textContent = '0 kJ';
}

// Inisialisasi
document.addEventListener('DOMContentLoaded', function() {
    // Select default molecule
    document.querySelector('.molecule-btn').click();
});
</script>

<style>
/* Custom slider styles */
input[type="range"] {
    -webkit-appearance: none;
    appearance: none;
    background: transparent;
    cursor: pointer;
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    background: white;
    border: 2px solid #8b5cf6;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

input[type="range"]::-moz-range-thumb {
    width: 20px;
    height: 20px;
    background: white;
    border: 2px solid #8b5cf6;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

/* Animation for molecules */
@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-5px) rotate(5deg); }
}

.molecule-btn.active {
    animation: float 2s ease-in-out infinite;
}
</style>
@endsection