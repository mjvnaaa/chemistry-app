@extends('layout')

@section('title', 'Simulasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        
        {{-- Header Section --}}
        <div class="text-center mb-8 fade-in">
            <a href="{{ route('landing') }}" 
               class="inline-flex items-center text-purple-600 hover:text-purple-800 mb-6 font-semibold transition-colors duration-300">
                🏠 Kembali ke Home
            </a>
            <h1 class="text-4xl font-extrabold text-gray-800 mb-3 flex items-center justify-center gap-3">
                <span class="text-5xl">🧬</span>
                Simulasi Molekul
            </h1>
            <p class="text-gray-600 text-lg">
                Seret molekul dan amati interaksi gaya antarmolekul secara real-time!
            </p>
        </div>

        {{-- Simulation Canvas Section --}}
        <div id="simulation-container" 
             class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 mb-8 border-l-8 border-purple-500 fade-in relative">
            
            {{-- Control Bar --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="text-3xl">🔬</span>
                    Lab Interaksi Molekul
                </h2>
                <div class="flex gap-3 items-center">
                    <span id="interaction-counter" 
                          class="px-5 py-2 rounded-full font-bold bg-purple-100 text-purple-600 border border-purple-200">
                        Interaksi: 0
                    </span>
                    <button onclick="resetSimulation()" 
                            class="px-5 py-2 rounded-full font-bold text-white bg-purple-600 hover:bg-purple-700 transition shadow-lg hover:shadow-purple-500/30">
                        🔄 Reset
                    </button>
                </div>
            </div>
            
            {{-- Canvas Container --}}
            <div class="relative rounded-2xl overflow-hidden bg-gray-50 border-2 border-gray-200 shadow-inner h-[400px]">
                {{-- Interaction Info Cards --}}
                <div id="interaction-cards" 
                     class="absolute top-4 left-4 z-10 flex flex-col gap-2 pointer-events-none max-w-xs">
                </div>

                {{-- SVG Canvas --}}
                <svg id="simulation-canvas" 
                     width="100%" 
                     height="100%" 
                     style="display: block; cursor: crosshair;">
                </svg>
            </div>
            
            {{-- Molecule Legend --}}
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

        {{-- Information Grid --}}
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            
            {{-- Panduan Simulasi --}}
            <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border-l-8 border-pink-500 fade-in" 
                 style="animation-delay: 0.1s;">
                <h3 class="font-bold text-gray-800 text-2xl mb-6 flex items-center gap-3">
                    <span class="text-3xl">🎯</span>
                    Panduan Simulasi
                </h3>
                <ol class="space-y-4 text-gray-600 relative">
                    <li class="flex items-start gap-3">
                        <span class="bg-pink-100 text-pink-600 rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">
                            1
                        </span>
                        <span><strong>Seret molekul</strong> menggunakan mouse atau sentuhan jari.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-pink-100 text-pink-600 rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">
                            2
                        </span>
                        <span><strong>Dekatkan molekul</strong> satu sama lain.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-pink-100 text-pink-600 rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">
                            3
                        </span>
                        <span><strong>Lihat kotak info</strong> yang muncul di pojok kiri atas canvas.</span>
                    </li>
                </ol>
            </div>

            {{-- Konsep yang Dipelajari --}}
            <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border-l-8 border-blue-500 fade-in" 
                 style="animation-delay: 0.2s;">
                <h3 class="font-bold text-gray-800 text-2xl mb-6 flex items-center gap-3">
                    <span class="text-3xl">💡</span>
                    Konsep yang Dipelajari
                </h3>
                <div class="space-y-4">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-2xl border border-blue-200">
                        <h4 class="font-bold text-blue-800 mb-1 flex items-center gap-2">
                            <span>🔵</span> Gaya London (Dispersi)
                        </h4>
                        <p class="text-blue-700 text-sm">
                            Lemah, terjadi pada semua molekul terutama non-polar.
                        </p>
                    </div>
                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 p-4 rounded-2xl border border-yellow-200">
                        <h4 class="font-bold text-yellow-800 mb-1 flex items-center gap-2">
                            <span>🟡</span> Dipol-Dipol
                        </h4>
                        <p class="text-yellow-700 text-sm">
                            Kekuatan sedang, terjadi antara molekul polar.
                        </p>
                    </div>
                    <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-2xl border border-green-200">
                        <h4 class="font-bold text-green-800 mb-1 flex items-center gap-2">
                            <span>🟢</span> Ikatan Hidrogen
                        </h4>
                        <p class="text-green-700 text-sm">
                            Paling kuat, terjadi pada ikatan H dengan F, O, atau N.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation Cards --}}
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
    </div>
</div>

<script>
// ============================================================
// DATA CONFIGURATION
// ============================================================

// Molekul dengan posisi awal
const molecules = [
    { id: 'H2O', x: 50, y: 150, color: '#3b82f6', label: 'H₂O' },
    { id: 'NH3', x: 150, y: 150, color: '#8b5cf6', label: 'NH₃' },
    { id: 'CH4', x: 250, y: 150, color: '#22c55e', label: 'CH₄' },
    { id: 'HCl', x: 350, y: 150, color: '#f59e0b', label: 'HCl' },
    { id: 'CO2', x: 450, y: 150, color: '#ef4444', label: 'CO₂' }
];

// Data interaksi lengkap dengan warna
const interactionsData = {
    'CO2-CH4': { 
        type: 'Gaya London', 
        strength: 'Lemah', 
        desc: 'Gaya dispersi antar molekul nonpolar',
        lineColor: '#ef4444', 
        bgClass: 'bg-red-500'
    },
    'H2O-NH3': { 
        type: 'Ikatan Hidrogen', 
        strength: 'Kuat', 
        desc: 'O-H...N membentuk ikatan hidrogen',
        lineColor: '#10b981', 
        bgClass: 'bg-green-500'
    },
    'H2O-HCl': { 
        type: 'Dipol-Dipol', 
        strength: 'Sedang', 
        desc: 'Interaksi antar molekul polar',
        lineColor: '#f59e0b', 
        bgClass: 'bg-yellow-500'
    },
    'NH3-HCl': { 
        type: 'Dipol-Dipol', 
        strength: 'Sedang', 
        desc: 'Interaksi antar molekul polar',
        lineColor: '#f59e0b', 
        bgClass: 'bg-yellow-500'
    }
};

// ============================================================
// STATE MANAGEMENT
// ============================================================

let currentInteractions = [];
let interactionCount = 0;
let dragging = null;

// ============================================================
// INITIALIZATION
// ============================================================

function initSimulation() {
    const svg = document.getElementById('simulation-canvas');
    svg.innerHTML = '';
    renderInteractions(svg);
    
    molecules.forEach(mol => {
        const g = createMoleculeElement(mol);
        svg.appendChild(g);
        
        g.addEventListener('mousedown', startDrag);
        g.addEventListener('touchstart', startDrag);
    });
    
    updateInteractionCounter();
    renderInteractionCards();
}

function createMoleculeElement(mol) {
    const g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
    g.setAttribute('class', 'molecule');
    g.setAttribute('data-id', mol.id);
    g.style.cursor = 'grab';
    
    // Outer glow circle
    const outerCircle = createSVGCircle(mol.x + 30, mol.y + 30, 32, mol.color, '0.2');
    
    // Main circle
    const circle = createSVGCircle(mol.x + 30, mol.y + 30, 28, mol.color, '1');
    circle.setAttribute('filter', 'drop-shadow(0px 2px 3px rgba(0,0,0,0.2))');
    
    // Label text
    const text = createSVGText(mol.x + 30, mol.y + 35, mol.label);
    
    g.appendChild(outerCircle);
    g.appendChild(circle);
    g.appendChild(text);
    
    return g;
}

function createSVGCircle(cx, cy, r, fill, opacity) {
    const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    circle.setAttribute('cx', cx);
    circle.setAttribute('cy', cy);
    circle.setAttribute('r', r);
    circle.setAttribute('fill', fill);
    circle.setAttribute('opacity', opacity);
    return circle;
}

function createSVGText(x, y, content) {
    const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    text.setAttribute('x', x);
    text.setAttribute('y', y);
    text.setAttribute('text-anchor', 'middle');
    text.setAttribute('fill', 'white');
    text.setAttribute('font-weight', 'bold');
    text.setAttribute('font-size', '14');
    text.setAttribute('style', 'pointer-events: none;');
    text.textContent = content;
    return text;
}

// ============================================================
// RENDERING FUNCTIONS
// ============================================================

function renderInteractions(svg) {
    const oldLines = svg.querySelectorAll('.interaction-line');
    oldLines.forEach(line => line.remove());
    
    currentInteractions.forEach(int => {
        const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        line.setAttribute('x1', int.x1);
        line.setAttribute('y1', int.y1);
        line.setAttribute('x2', int.x2);
        line.setAttribute('y2', int.y2);
        line.setAttribute('stroke', int.lineColor);
        line.setAttribute('stroke-width', '4');
        line.setAttribute('class', 'interaction-line');
        line.style.strokeDasharray = '8,4';
        line.style.animation = 'dash 1s linear infinite';
        svg.insertBefore(line, svg.firstChild);
    });
}

function renderInteractionCards() {
    const container = document.getElementById('interaction-cards');
    container.innerHTML = '';

    currentInteractions.forEach(int => {
        const card = document.createElement('div');
        card.className = `${int.bgClass} text-white px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 animate-slideIn`;
        
        card.innerHTML = `
            <h4 class="font-bold text-sm mb-0.5">${int.type}</h4>
            <div class="text-xs font-semibold opacity-90">Kekuatan: ${int.strength}</div>
            <div class="text-xs opacity-90">${int.desc}</div>
        `;
        
        container.appendChild(card);
    });
}

function updateInteractionCounter() {
    document.getElementById('interaction-counter').textContent = `Interaksi: ${interactionCount}`;
}

// ============================================================
// INTERACTION DETECTION
// ============================================================

function calculateDistance(mol1, mol2) {
    const dx = mol1.x - mol2.x;
    const dy = mol1.y - mol2.y;
    return Math.sqrt(dx * dx + dy * dy);
}

function detectInteractions() {
    const newInteractions = [];
    
    for (let i = 0; i < molecules.length; i++) {
        for (let j = i + 1; j < molecules.length; j++) {
            const distance = calculateDistance(molecules[i], molecules[j]);
            
            if (distance < 110) {
                const key1 = `${molecules[i].id}-${molecules[j].id}`;
                const key2 = `${molecules[j].id}-${molecules[i].id}`;
                const interaction = interactionsData[key1] || interactionsData[key2];
                
                if (interaction) {
                    newInteractions.push({
                        id: key1,
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
    
    if (newInteractions.length !== currentInteractions.length) {
        interactionCount = newInteractions.length;
        updateInteractionCounter();
    }
    
    currentInteractions = newInteractions;
    
    const svg = document.getElementById('simulation-canvas');
    renderInteractions(svg);
    renderInteractionCards();
}

// ============================================================
// DRAG AND DROP FUNCTIONALITY
// ============================================================

function startDrag(e) {
    e.preventDefault();
    
    const id = e.currentTarget.dataset.id;
    const molecule = molecules.find(m => m.id === id);
    if (!molecule) return;
    
    const svg = document.getElementById('simulation-canvas');
    const rect = svg.getBoundingClientRect();
    
    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
    
    dragging = {
        id: id,
        offsetX: clientX - rect.left - molecule.x - 30,
        offsetY: clientY - rect.top - molecule.y - 30
    };
    
    e.currentTarget.style.cursor = 'grabbing';
    
    document.addEventListener('mousemove', drag);
    document.addEventListener('touchmove', drag);
    document.addEventListener('mouseup', endDrag);
    document.addEventListener('touchend', endDrag);
}

function drag(e) {
    if (!dragging) return;
    
    const svg = document.getElementById('simulation-canvas');
    const rect = svg.getBoundingClientRect();
    
    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
    
    const molecule = molecules.find(m => m.id === dragging.id);
    molecule.x = Math.max(0, Math.min(rect.width - 60, clientX - rect.left - dragging.offsetX - 30));
    molecule.y = Math.max(0, Math.min(rect.height - 60, clientY - rect.top - dragging.offsetY - 30));
    
    updateMoleculePosition(dragging.id, molecule);
    detectInteractions();
}

function updateMoleculePosition(id, molecule) {
    const g = document.querySelector(`[data-id="${id}"]`);
    if (!g) return;
    
    const circles = g.querySelectorAll('circle');
    circles[0].setAttribute('cx', molecule.x + 30);
    circles[0].setAttribute('cy', molecule.y + 30);
    circles[1].setAttribute('cx', molecule.x + 30);
    circles[1].setAttribute('cy', molecule.y + 30);
    
    const text = g.querySelector('text');
    text.setAttribute('x', molecule.x + 30);
    text.setAttribute('y', molecule.y + 35);
}

function endDrag() {
    if (dragging) {
        const g = document.querySelector(`[data-id="${dragging.id}"]`);
        if (g) g.style.cursor = 'grab';
        dragging = null;
    }
    
    document.removeEventListener('mousemove', drag);
    document.removeEventListener('touchmove', drag);
    document.removeEventListener('mouseup', endDrag);
    document.removeEventListener('touchend', endDrag);
}

// ============================================================
// RESET FUNCTION
// ============================================================

function resetSimulation() {
    molecules[0] = { id: 'H2O', x: 50, y: 150, color: '#3b82f6', label: 'H₂O' };
    molecules[1] = { id: 'NH3', x: 150, y: 150, color: '#8b5cf6', label: 'NH₃' };
    molecules[2] = { id: 'CH4', x: 250, y: 150, color: '#22c55e', label: 'CH₄' };
    molecules[3] = { id: 'HCl', x: 350, y: 150, color: '#f59e0b', label: 'HCl' };
    molecules[4] = { id: 'CO2', x: 450, y: 150, color: '#ef4444', label: 'CO₂' };
    
    currentInteractions = [];
    interactionCount = 0;
    initSimulation();
}

// ============================================================
// INITIALIZATION AND STYLES
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    initSimulation();
    
    const style = document.createElement('style');
    style.textContent = `
        @keyframes dash {
            to { stroke-dashoffset: -20; }
        }
        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slideIn {
            animation: slideIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    `;
    document.head.appendChild(style);
});

// Prevent right-click context menu
document.addEventListener('contextmenu', e => e.preventDefault());
</script>
@endsection