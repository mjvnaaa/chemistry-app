@extends('layout')

@section('title', 'Simulasi Molekul Interaktif')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 mb-6 font-semibold">
                ΓåÉ Kembali ke Home
            </a>
            <h1 class="text-4xl font-bold text-gray-800 mb-3 flex items-center justify-center gap-3">
                <span class="text-5xl">🧬</span>
                Simulasi Molekul Interaktif
            </h1>
            <p class="text-gray-600 text-lg">Seret molekul dan amati interaksi gaya antarmolekul secara real-time!</p>
        </div>

        <!-- Simulasi Container -->
        <div id="simulation-container" class="bg-white rounded-2xl shadow-2xl p-4 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <span class="text-2xl">🔬</span>
                    Lab Interaksi Molekul
                </h2>
                <div class="flex gap-3 items-center">
                    <span id="interaction-counter" class="px-4 py-2 rounded-lg font-semibold bg-purple-100 text-purple-600">
                        Interaksi: 0
                    </span>
                    <button onclick="resetSimulation()" class="px-4 py-2 rounded-lg font-semibold text-white bg-purple-600 hover:bg-purple-700 transition">
                        🔄 Reset
                    </button>
                </div>
            </div>
            
            <div class="relative rounded-lg overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                <svg id="simulation-canvas" width="100%" height="400" style="max-width: 600px; display: block; margin: 0 auto;">
                    <!-- Canvas akan diisi oleh JavaScript -->
                </svg>
            </div>
            
            <!-- Legend -->
            <div class="mt-6 grid grid-cols-5 gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-blue-500"></div>
                    <span class="text-sm">H₂O</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-purple-500"></div>
                    <span class="text-sm">NH₃</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-green-500"></div>
                    <span class="text-sm">CH₄</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-yellow-500"></div>
                    <span class="text-sm">HCl</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-red-500"></div>
                    <span class="text-sm">CO₂</span>
                </div>
            </div>
        </div>

        <!-- Panduan -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                <h3 class="font-bold text-purple-800 text-xl mb-4 flex items-center gap-2">
                    <span class="text-2xl">🎯</span>
                    Panduan Simulasi
                </h3>
                <ol class="list-decimal list-inside space-y-3 text-gray-700">
                    <li><strong>Seret molekul</strong> menggunakan mouse/touch</li>
                    <li><strong>Dekatkan molekul</strong> hingga jarak &lt; 100px</li>
                    <li><strong>Garis interaksi</strong> akan muncul otomatis</li>
                    <li><strong>Baca informasi</strong> jenis dan kekuatan interaksi</li>
                    <li><strong>Cari semua interaksi</strong> yang mungkin terjadi!</li>
                </ol>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <h3 class="font-bold text-blue-800 text-xl mb-4 flex items-center gap-2">
                    <span class="text-2xl">💡</span>
                    Konsep yang Dipelajari
                </h3>
                <div class="space-y-4 text-gray-700">
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <h4 class="font-bold text-blue-700 mb-1">🔵 Gaya London (Dispersi)</h4>
                        <p class="text-sm">Lemah, terjadi pada semua molekul non-polar</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <h4 class="font-bold text-purple-700 mb-1">🟣 Dipol-Dipol</h4>
                        <p class="text-sm">Sedang, terjadi antara molekul polar</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <h4 class="font-bold text-green-700 mb-1">🟢 Ikatan Hidrogen</h4>
                        <p class="text-sm">Kuat, terjadi pada H-F, H-O, H-N</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Interaksi -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="font-bold text-gray-800 text-xl mb-4 flex items-center gap-2">
                <span class="text-2xl">📊</span>
                Jenis Interaksi Molekul
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-gray-700 font-bold">Molekul 1</th>
                            <th class="p-3 text-gray-700 font-bold">Molekul 2</th>
                            <th class="p-3 text-gray-700 font-bold">Jenis Gaya</th>
                            <th class="p-3 text-gray-700 font-bold">Kekuatan</th>
                            <th class="p-3 text-gray-700 font-bold">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-bold text-blue-600">H₂O</td>
                            <td class="p-3 font-bold text-blue-600">H₂O</td>
                            <td class="p-3"><span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Ikatan Hidrogen</span></td>
                            <td class="p-3 font-bold text-green-600">Kuat</td>
                            <td class="p-3 text-sm">O-H...O membentuk ikatan hidrogen sangat kuat</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-bold text-blue-600">H₂O</td>
                            <td class="p-3 font-bold text-purple-600">NH₃</td>
                            <td class="p-3"><span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Ikatan Hidrogen</span></td>
                            <td class="p-3 font-bold text-green-600">Kuat</td>
                            <td class="p-3 text-sm">O-H...N membentuk ikatan hidrogen</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-bold text-blue-600">H₂O</td>
                            <td class="p-3 font-bold text-yellow-600">HCl</td>
                            <td class="p-3"><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Dipol-Dipol</span></td>
                            <td class="p-3 font-bold text-yellow-600">Sedang</td>
                            <td class="p-3 text-sm">Interaksi antara molekul polar</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-bold text-purple-600">NH₃</td>
                            <td class="p-3 font-bold text-purple-600">NH₃</td>
                            <td class="p-3"><span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Ikatan Hidrogen</span></td>
                            <td class="p-3 font-bold text-green-600">Kuat</td>
                            <td class="p-3 text-sm">N-H...N membentuk ikatan hidrogen</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-bold text-green-600">CH₄</td>
                            <td class="p-3 font-bold text-green-600">CH₄</td>
                            <td class="p-3"><span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Gaya London</span></td>
                            <td class="p-3 font-bold text-red-600">Lemah</td>
                            <td class="p-3 text-sm">Gaya dispersi antar molekul nonpolar</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tujuan Pembelajaran -->
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <h3 class="text-xl font-bold mb-4 flex items-center gap-3">
                <span class="text-3xl">🎯</span>
                Tujuan Pembelajaran
            </h3>
            <ul class="space-y-3">
                <li class="flex items-start gap-3">
                    <span class="bg-white text-purple-600 rounded-full w-6 h-6 flex items-center justify-center font-bold flex-shrink-0">1</span>
                    <span>Memahami perbedaan gaya London, dipol-dipol, dan ikatan hidrogen</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="bg-white text-purple-600 rounded-full w-6 h-6 flex items-center justify-center font-bold flex-shrink-0">2</span>
                    <span>Menganalisis faktor jarak dan polaritas dalam interaksi molekul</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="bg-white text-purple-600 rounded-full w-6 h-6 flex items-center justify-center font-bold flex-shrink-0">3</span>
                    <span>Memprediksi jenis interaksi berdasarkan molekul yang berdekatan</span>
                </li>
            </ul>
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <a href="{{ route('materi') }}"
               class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition text-center">
                <span class="flex items-center justify-center gap-2">
                    <span>📖</span>
                    <span>Review Materi</span>
                </span>
            </a>
            <a href="{{ route('simulasi') }}"
               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition text-center">
                <span class="flex items-center justify-center gap-2">
                    <span>🔬</span>
                    <span>Simulasi PhET</span>
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
// Data Molekul
const molecules = [
    { id: 'H2O', x: 50, y: 50, color: '#3b82f6', label: 'H₂O' },
    { id: 'NH3', x: 150, y: 50, color: '#8b5cf6', label: 'NH₃' },
    { id: 'CH4', x: 250, y: 50, color: '#22c55e', label: 'CH₄' },
    { id: 'HCl', x: 350, y: 50, color: '#f59e0b', label: 'HCl' },
    { id: 'CO2', x: 450, y: 50, color: '#ef4444', label: 'CO₂' }
];

// Data Interaksi
const interactionsData = {
    'H2O-H2O': { type: 'Ikatan Hidrogen', strength: 'Kuat', color: '#10b981' },
    'H2O-NH3': { type: 'Ikatan Hidrogen', strength: 'Kuat', color: '#10b981' },
    'H2O-HCl': { type: 'Dipol-Dipol', strength: 'Sedang', color: '#f59e0b' },
    'NH3-NH3': { type: 'Ikatan Hidrogen', strength: 'Kuat', color: '#10b981' },
    'NH3-HCl': { type: 'Dipol-Dipol', strength: 'Sedang', color: '#f59e0b' },
    'CH4-CH4': { type: 'Gaya London', strength: 'Lemah', color: '#ef4444' },
    'HCl-HCl': { type: 'Dipol-Dipol', strength: 'Sedang', color: '#f59e0b' }
};

let currentInteractions = [];
let interactionCount = 0;
let dragging = null;
let offsetX = 0;
let offsetY = 0;

// Inisialisasi SVG
function initSimulation() {
    const svg = document.getElementById('simulation-canvas');
    svg.innerHTML = '';
    
    // Gambar interaksi terlebih dahulu
    renderInteractions(svg);
    
    // Gambar molekul
    molecules.forEach(mol => {
        const g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
        g.setAttribute('class', 'molecule');
        g.setAttribute('data-id', mol.id);
        g.style.cursor = 'grab';
        
        const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
        circle.setAttribute('cx', mol.x + 30);
        circle.setAttribute('cy', mol.y + 30);
        circle.setAttribute('r', 28);
        circle.setAttribute('fill', mol.color);
        circle.setAttribute('opacity', '0.9');
        
        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', mol.x + 30);
        text.setAttribute('y', mol.y + 35);
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('fill', 'white');
        text.setAttribute('font-weight', 'bold');
        text.setAttribute('font-size', '14');
        text.textContent = mol.label;
        
        g.appendChild(circle);
        g.appendChild(text);
        svg.appendChild(g);
        
        // Event listeners
        g.addEventListener('mousedown', startDrag);
        g.addEventListener('touchstart', startDrag);
    });
    
    // Update counter
    document.getElementById('interaction-counter').textContent = `Interaksi: ${interactionCount}`;
}

// Render interaksi
function renderInteractions(svg) {
    // Hapus interaksi lama
    const oldLines = svg.querySelectorAll('.interaction-line');
    oldLines.forEach(line => line.remove());
    
    // Gambar interaksi baru
    currentInteractions.forEach(int => {
        const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        line.setAttribute('x1', int.x1);
        line.setAttribute('y1', int.y1);
        line.setAttribute('x2', int.x2);
        line.setAttribute('y2', int.y2);
        line.setAttribute('stroke', int.color);
        line.setAttribute('stroke-width', '2');
        line.setAttribute('class', 'interaction-line');
        line.style.strokeDasharray = '5,5';
        line.style.animation = 'dash 1s linear infinite';
        
        svg.appendChild(line);
    });
}

// Hitung jarak
function calculateDistance(mol1, mol2) {
    const dx = mol1.x - mol2.x;
    const dy = mol1.y - mol2.y;
    return Math.sqrt(dx * dx + dy * dy);
}

// Deteksi interaksi
function detectInteractions() {
    const newInteractions = [];
    
    for (let i = 0; i < molecules.length; i++) {
        for (let j = i + 1; j < molecules.length; j++) {
            const distance = calculateDistance(molecules[i], molecules[j]);
            if (distance < 100) {
                const key1 = `${molecules[i].id}-${molecules[j].id}`;
                const key2 = `${molecules[j].id}-${molecules[i].id}`;
                const interaction = interactionsData[key1] || interactionsData[key2];
                
                if (interaction) {
                    newInteractions.push({
                        x1: molecules[i].x + 30,
                        y1: molecules[i].y + 30,
                        x2: molecules[j].x + 30,
                        y2: molecules[j].y + 30,
                        ...interaction
                    });
                }
            }
        }
    }
    
    // Update counter jika ada interaksi baru
    if (newInteractions.length > currentInteractions.length) {
        interactionCount += (newInteractions.length - currentInteractions.length);
        document.getElementById('interaction-counter').textContent = `Interaksi: ${interactionCount}`;
        
        // Celebration jika mencapai 5 interaksi
        if (interactionCount === 5) {
            showToast('🎉 Pencapaian: Menemukan 5 interaksi molekul!');
        }
    }
    
    currentInteractions = newInteractions;
    
    // Render ulang
    const svg = document.getElementById('simulation-canvas');
    renderInteractions(svg);
}

// Drag functions
function startDrag(e) {
    e.preventDefault();
    const id = e.currentTarget.dataset.id;
    const molecule = molecules.find(m => m.id === id);
    
    if (!molecule) return;
    
    const svg = document.getElementById('simulation-canvas');
    const rect = svg.getBoundingClientRect();
    
    let clientX, clientY;
    if (e.type === 'touchstart') {
        clientX = e.touches[0].clientX;
        clientY = e.touches[0].clientY;
    } else {
        clientX = e.clientX;
        clientY = e.clientY;
    }
    
    dragging = {
        id: id,
        offsetX: clientX - rect.left - molecule.x - 30,
        offsetY: clientY - rect.top - molecule.y - 30
    };
    
    e.currentTarget.style.cursor = 'grabbing';
    
    // Add global listeners
    document.addEventListener('mousemove', drag);
    document.addEventListener('touchmove', drag);
    document.addEventListener('mouseup', endDrag);
    document.addEventListener('touchend', endDrag);
}

function drag(e) {
    if (!dragging) return;
    
    const svg = document.getElementById('simulation-canvas');
    const rect = svg.getBoundingClientRect();
    
    let clientX, clientY;
    if (e.type === 'touchmove') {
        clientX = e.touches[0].clientX;
        clientY = e.touches[0].clientY;
    } else {
        clientX = e.clientX;
        clientY = e.clientY;
    }
    
    const molecule = molecules.find(m => m.id === dragging.id);
    if (!molecule) return;
    
    // Update position dengan batas
    molecule.x = Math.max(0, Math.min(540, clientX - rect.left - dragging.offsetX - 30));
    molecule.y = Math.max(0, Math.min(340, clientY - rect.top - dragging.offsetY - 30));
    
    // Update visual
    const g = document.querySelector(`[data-id="${dragging.id}"]`);
    if (g) {
        g.querySelector('circle').setAttribute('cx', molecule.x + 30);
        g.querySelector('circle').setAttribute('cy', molecule.y + 30);
        g.querySelector('text').setAttribute('x', molecule.x + 30);
        g.querySelector('text').setAttribute('y', molecule.y + 35);
    }
    
    detectInteractions();
}

function endDrag() {
    if (dragging) {
        const g = document.querySelector(`[data-id="${dragging.id}"]`);
        if (g) g.style.cursor = 'grab';
        dragging = null;
    }
    
    // Remove global listeners
    document.removeEventListener('mousemove', drag);
    document.removeEventListener('touchmove', drag);
    document.removeEventListener('mouseup', endDrag);
    document.removeEventListener('touchend', endDrag);
}

// Reset simulation
function resetSimulation() {
    molecules[0] = { id: 'H2O', x: 50, y: 50, color: '#3b82f6', label: 'H₂O' };
    molecules[1] = { id: 'NH3', x: 150, y: 50, color: '#8b5cf6', label: 'NH₃' };
    molecules[2] = { id: 'CH4', x: 250, y: 50, color: '#22c55e', label: 'CH₄' };
    molecules[3] = { id: 'HCl', x: 350, y: 50, color: '#f59e0b', label: 'HCl' };
    molecules[4] = { id: 'CO2', x: 450, y: 50, color: '#ef4444', label: 'CO₂' };
    
    currentInteractions = [];
    interactionCount = 0;
    
    initSimulation();
    showToast('🔄 Simulasi direset ke posisi awal!');
}

// Show toast notification
function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slideIn';
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Inisialisasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    initSimulation();
    
    // Add CSS animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes dash {
            to { stroke-dashoffset: -10; }
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .animate-slideIn {
            animation: slideIn 0.3s ease;
        }
        .molecule {
            transition: transform 0.1s;
        }
    `;
    document.head.appendChild(style);
});

// Prevent context menu on touch devices
document.addEventListener('contextmenu', e => e.preventDefault());
</script>
@endsection