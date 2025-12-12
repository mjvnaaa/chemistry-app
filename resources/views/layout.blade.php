<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Chemistry Learning App')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* --- Base Settings --- */
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { background-color: #f9fafb; overflow-x: hidden; }

        /* --- Global Utility Classes --- */
        /* Background Gradient dengan Animasi Pulse Halus */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            z-index: 0;
        }
        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: pulse-bg 4s ease-in-out infinite;
            z-index: -1;
        }

        /* Interactive Elements */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
        }
        
        /* Ensure Inputs interact correctly */
        input, select, button, a { position: relative; z-index: 10; }
        input:focus, select:focus { outline: none; box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.3); }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #667eea; border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: #764ba2; }

        /* --- Custom Form Elements (Radio & Range) --- */
        /* Radio Button Kuis */
        input[type="radio"] { cursor: pointer; accent-color: #7c3aed; }
        input[type="radio"]:checked + span { color: #7c3aed; font-weight: 600; }
        label:has(input[type="radio"]:checked) { background-color: #f3e8ff; border-color: #7c3aed !important; }
        
        /* Range Slider Simulasi */
        input[type="range"] { -webkit-appearance: none; appearance: none; background: transparent; cursor: pointer; }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none; appearance: none;
            width: 20px; height: 20px;
            background: white; border: 2px solid #8b5cf6; border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2); margin-top: -8px;
        }
        input[type="range"]::-webkit-slider-runnable-track { height: 4px; border-radius: 2px; }

        /* --- Animations --- */
        /* Fade In Up */
        .fade-in { animation: fadeIn 0.8s ease-out forwards; opacity: 0; transform: translateY(30px); }
        @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }

        /* Pulse Background */
        @keyframes pulse-bg { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }

        /* Floating Element */
        .animate-float { animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }

        /* Bouncing */
        .animate-bounce { animation: bounce 2s infinite; }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

        /* Shaking (Error/Warning) */
        @keyframes shake { 
            0%, 100% { transform: translateX(0); } 
            25% { transform: translateX(-5px); } 
            75% { transform: translateX(5px); } 
        }
        .animate-shake { animation: shake 0.4s ease-in-out; }

        /* Molecule Specific */
        .molecule { transition: transform 0.1s; cursor: grab; }
        .molecule:active { cursor: grabbing; }
        
        /* Prose text spacing */
        .prose { line-height: 1.8; }
        .prose p { margin-bottom: 1em; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800">

    @yield('content')

    <button id="scrollTopBtn" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" 
            class="fixed bottom-8 right-8 bg-purple-600 text-white p-4 rounded-full shadow-2xl hover:bg-purple-700 transition-all duration-300 opacity-0 pointer-events-none z-50 transform hover:scale-110">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script>
        // Scroll to Top Logic
        const scrollTopBtn = document.getElementById('scrollTopBtn');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                scrollTopBtn.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        // Trigger Fade In elements on scroll
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            });
            document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
        });
    </script>

    @stack('scripts')
</body>
</html>