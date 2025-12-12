@extends('layout')

@section('title', 'Simulasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-8 fade-in">
            <a href="{{ route('landing') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 mb-6 font-semibold transition-colors duration-300">
                🏠 Kembali ke Home
            </a>
            <h1 class="text-4xl font-extrabold text-gray-800 mb-3 flex items-center justify-center gap-3">
                <span class="text-5xl">🧬</span>
                Simulasi Molekul
            </h1>
            <p class="text-gray-600 text-lg">Seret molekul dan amati interaksi gaya antarmolekul secara real-time!</p>
        </div>

        <div id="simulation-container" class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 mb-8 border-l-8 border-purple-500 fade-in">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="text-3xl">🔬</span>
                    Lab Interaksi Molekul
                </h2>
                <div class="flex gap-3 items-center">
                    <span id="interaction-counter" class="px-5 py-2 rounded-full font-bold bg-purple-100 text-purple-600 border border-purple-200">
                        Interaksi: 0
                    </span>
                    <button onclick="resetSimulation()" class="px-5 py-2 rounded-full font-bold text-white bg-purple-600 hover:bg-purple-700 transition shadow-lg hover:shadow-purple-500/30">
                        🔄 Reset
                    </button>
                </div>
            </div>
            
            <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 shadow-inner">
                <svg id="simulation-canvas" width="100%" height="400" style="max-width: 100%; display: block; margin: 0 auto; cursor: crosshair;">
                    </svg>
            </div>
            
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <div class="flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-full border border-blue-200">
                    <div class="w-4 h-4 rounded-full bg-blue-500 shadow-sm"></div>
                    <span class="text-sm font-semibold text-blue-700">H₂O</span>
                </div>
                <div class="flex items-center gap-2 bg-purple-50 px-4 py-2 rounded-full border border-purple-200">
                    <div class="w-4 h-4 rounded-full bg-purple-500 shadow-sm"></div>
                    <span class="text-sm font-semibold text-purple-700">NH₃</span>
                </div>
                <div class="flex items-center gap-2 bg-green-50 px-4 py-2 rounded-full border border-green-200">
                    <div class="w-4 h-4 rounded-full bg-green-500 shadow-sm"></div>
                    <span class="text-sm font-semibold text-green-700">CH₄</span>
                </div>
                <div class="flex items-center gap-2 bg-yellow-50 px-4 py-2 rounded-full border border-yellow-200">
                    <div class="w-4 h-4 rounded-full bg-yellow-500 shadow-sm"></div>
                    <span class="text-sm font-semibold text-yellow-700">HCl</span>
                </div>
                <div class="flex items-center gap-2 bg-red-50 px-4 py-2 rounded-full border border-red-200">
                    <div class="w-4 h-4 rounded-full bg-red-500 shadow-sm"></div>
                    <span class="text-sm font-semibold text-red-700">CO₂</span>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border-l-8 border-pink-500 fade-in" style="animation-delay: 0.1s;">
                <h3 class="font-bold text-gray-800 text-2xl mb-6 flex items-center gap-3">
                    <span class="text-3xl">🎯</span>
                    Panduan Simulasi
                </h3>
                <ol class="space-y-4 text-gray-600 relative">
                    <li class="flex items-start gap-3">
                        <span class="bg-pink-100 text-pink-600 rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">1</span>
                        <span><strong>Seret molekul</strong> menggunakan mouse atau sentuhan jari.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-pink-100 text-pink-600 rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">2</span>
                        <span><strong>Dekatkan molekul</strong> satu sama lain hingga jarak &lt; 100px.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-pink-100 text-pink-600 rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">3</span>
                        <span><strong>Garis interaksi</strong> putus-putus akan muncul otomatis.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-pink-100 text-pink-600 rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">4</span>
                        <span><strong>Baca informasi</strong> yang muncul mengenai jenis dan kekuatan gaya.</span>
                    </li>
                </ol>
            </div>

            <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border-l-8 border-blue-500 fade-in" style="animation-delay: 0.2s;">
                <h3 class="font-bold text-gray-800 text-2xl mb-6 flex items-center gap-3">
                    <span class="text-3xl">💡</span>
                    Konsep yang Dipelajari
                </h3>
                <div class="space-y-4">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-2xl border border-blue-200">
                        <h4 class="font-bold text-blue-800 mb-1 flex items-center gap-2">
                            <span>🔵</span> Gaya London (Dispersi)
                        </h4>
                        <p class="text-blue-700 text-sm">Lemah, terjadi pada semua molekul terutama non-polar.</p>
                    </div>
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-2xl border border-purple-200">
                        <h4 class="font-bold text-purple-800 mb-1 flex items-center gap-2">
                            <span>🟣</span> Dipol-Dipol
                        </h4>
                        <p class="text-purple-700 text-sm">Kekuatan sedang, terjadi antara molekul polar.</p>
                    </div>
                    <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-2xl border border-green-200">
                        <h4 class="font-bold text-green-800 mb-1 flex items-center gap-2">
                            <span>🟢</span> Ikatan Hidrogen
                        </h4>
                        <p class="text-green-700 text-sm">Paling kuat, terjadi pada ikatan H dengan F, O, atau N.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 mb-8 border-l-8 border-green-500 fade-in" style="animation-delay: 0.3s;">
            <h3 class="font-bold text-gray-800 text-2xl mb-6 flex items-center gap-3">
                <span class="text-3xl">📊</span>
                Referensi Jenis Interaksi
            </h3>
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="p-4 font-extrabold uppercase text-xs tracking-wider">Molekul 1</th>
                            <th class="p-4 font-extrabold uppercase text-xs tracking-wider">Molekul 2</th>
                            <th class="p-4 font-extrabold uppercase text-xs tracking-wider">Jenis Gaya</th>
                            <th class="p-4 font-extrabold uppercase text-xs tracking-wider">Kekuatan</th>
                            <th class="p-4 font-extrabold uppercase text-xs tracking-wider">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="p-4 font-bold text-blue-600">H₂O</td>
                            <td class="p-4 font-bold text-blue-600">H₂O</td>
                            <td class="p-4"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Ikatan Hidrogen</span></td>
                            <td class="p-4 font-bold text-green-600">Kuat</td>
                            <td class="p-4 text-sm text-gray-600">O-H...O membentuk ikatan hidrogen sangat kuat</td>
                        </tr>
                        <tr class="hover:bg-purple-50 transition-colors">
                            <td class="p-4 font-bold text-blue-600">H₂O</td>
                            <td class="p-4 font-bold text-purple-600">NH₃</td>
                            <td class="p-4"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Ikatan Hidrogen</span></td>
                            <td class="p-4 font-bold text-green-600">Kuat</td>
                            <td class="p-4 text-sm text-gray-600">O-H...N membentuk ikatan hidrogen</td>
                        </tr>
                        <tr class="hover:bg-yellow-50 transition-colors">
                            <td class="p-4 font-bold text-blue-600">H₂O</td>
                            <td class="p-4 font-bold text-yellow-600">HCl</td>
                            <td class="p-4"><span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Dipol-Dipol</span></td>
                            <td class="p-4 font-bold text-yellow-600">Sedang</td>
                            <td class="p-4 text-sm text-gray-600">Interaksi antara molekul polar</td>
                        </tr>
                        <tr class="hover:bg-purple-50 transition-colors">
                            <td class="p-4 font-bold text-purple-600">NH₃</td>
                            <td class="p-4 font-bold text-purple-600">NH₃</td>
                            <td class="p-4"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Ikatan Hidrogen</span></td>
                            <td class="p-4 font-bold text-green-600">Kuat</td>
                            <td class="p-4 text-sm text-gray-600">N-H...N membentuk ikatan hidrogen</td>
                        </tr>
                        <tr class="hover:bg-red-50 transition-colors">
                            <td class="p-4 font-bold text-green-600">CH₄</td>
                            <td class="p-4 font-bold text-green-600">CH₄</td>
                            <td class="p-4"><span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Gaya London</span></td>
                            <td class="p-4 font-bold text-red-600">Lemah</td>
                            <td class="p-4 text-sm text-gray-600">Gaya dispersi antar molekul nonpolar</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

<div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 fade-in" style="animation-delay: 0.4s;">
    <a href="{{ route('materi') }}" 
       class="group relative bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-6 px-8 rounded-2xl text-center font-bold text-xl hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10 flex flex-col items-center justify-center gap-3">
            <span class="text-5xl">📖</span>
            <div>
                <div class="text-lg font-semibold opacity-90">Kembali ke</div>
                <div class="text-xl">Materi</div>
            </div>
        </div>
    </a>

    <a href="{{ route('simulasi') }}" 
       class="group relative bg-gradient-to-r from-green-600 to-teal-600 text-white py-6 px-8 rounded-2xl text-center font-bold text-xl hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
        <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-teal-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10 flex flex-col items-center justify-center gap-3">
            <span class="text-5xl">🔬</span>
            <div>
                <div class="text-lg font-semibold opacity-90">Lanjut ke</div>
                <div class="text-xl">Virtual Lab</div>
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
        circle.setAttribute('filter', 'drop-shadow(0px 2px 3px rgba(0,0,0,0.2))'); // Add depth
        
        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', mol.x + 30);
        text.setAttribute('y', mol.y + 35);
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('fill', 'white');
        text.setAttribute('font-weight', 'bold');
        text.setAttribute('font-size', '14');
        text.setAttribute('style', 'pointer-events: none;'); // Allow click through text
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
        line.setAttribute('stroke-width', '3'); // Thicker line
        line.setAttribute('class', 'interaction-line');
        line.style.strokeDasharray = '8,4';
        line.style.animation = 'dash 1s linear infinite';
        
        svg.insertBefore(line, svg.firstChild); // Place lines behind molecules
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
            showToast('🎉 Hebat! Kamu menemukan 5 interaksi!');
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
    e.currentTarget.setAttribute('opacity', '1'); // Highlight dragged item
    
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
    molecule.x = Math.max(0, Math.min(rect.width - 60, clientX - rect.left - dragging.offsetX - 30));
    molecule.y = Math.max(0, Math.min(rect.height - 60, clientY - rect.top - dragging.offsetY - 30));
    
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
        if (g) {
            g.style.cursor = 'grab';
            g.querySelector('circle').setAttribute('opacity', '0.9'); // Restore opacity
        }
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
    showToast('🔄 Posisi molekul telah direset!');
}

// Show toast notification
function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-8 right-8 bg-gray-800 text-white px-6 py-4 rounded-xl shadow-2xl z-50 animate-slideIn flex items-center gap-3 border border-gray-700';
    toast.innerHTML = `<span class="text-xl">✨</span><span class="font-semibold">${message}</span>`;
    
    document.body.appendChild(toast);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(100%)';
        toast.style.transition = 'all 0.5s ease';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

// Inisialisasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    initSimulation();
    
    // Add CSS animation for dash lines
    const style = document.createElement('style');
    style.textContent = `
        @keyframes dash {
            to { stroke-dashoffset: -20; }
        }
        @keyframes slideIn {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slideIn {
            animation: slideIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    `;
    document.head.appendChild(style);
});

// Prevent context menu on touch devices
document.addEventListener('contextmenu', e => e.preventDefault());
</script>
@endsection