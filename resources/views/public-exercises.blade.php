<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exercices de Respiration - CesiZen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .text-gradient {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="antialiased bg-[#F8FAFC] text-slate-900">

    <!-- Navigation Minimaliste -->
    <nav class="w-full bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="bg-cesi-green p-1.5 rounded-lg transition-transform group-hover:rotate-12">
                    <img src="{{ asset('logo.png') }}" class="h-6 w-6 brightness-0 invert" alt="CesiZen">
                </div>
                <span class="font-extrabold text-xl tracking-tight text-slate-800">Cesi<span class="text-cesi-green">Zen</span></span>
            </a>
            <div class="flex items-center gap-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="font-bold text-slate-600 hover:text-cesi-green transition">Mon Espace</a>
                @else
                    <a href="{{ route('login') }}" class="font-bold text-slate-600 hover:text-cesi-green transition">Connexion</a>
                    <a href="{{ route('register') }}" class="hidden sm:block px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-200">Rejoindre</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-12 sm:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight">
                Respirez. <span class="text-gradient">Relâchez.</span>
            </h1>
            <p class="text-slate-500 text-lg sm:text-xl max-w-2xl mx-auto leading-relaxed">
                Découvrez nos techniques de respiration guidées pour réduire le stress et améliorer votre concentration en quelques minutes.
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($exercises as $exercise)
                <div class="group relative bg-white rounded-[2rem] p-8 shadow-sm hover:shadow-xl hover:shadow-green-500/5 transition-all duration-500 border border-slate-100 flex flex-col overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>
                    
                    <div class="relative">
                        <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-cesi-green transition-colors duration-300">
                            <svg class="w-8 h-8 text-cesi-green group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z"></path>
                            </svg>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider rounded-full">{{ $exercise->duration_inhale }}s - {{ $exercise->duration_hold }}s - {{ $exercise->duration_exhale }}s</span>
                            @if($exercise->duration_hold > 0)
                                <span class="px-3 py-1 bg-purple-50 text-purple-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Apnée</span>
                            @else
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Continu</span>
                            @endif
                        </div>

                        <h3 class="text-2xl font-bold text-slate-800 mb-4 group-hover:text-cesi-green transition-colors">{{ $exercise->name }}</h3>
                        
                        <p class="text-slate-500 mb-8 line-clamp-3 text-sm leading-relaxed min-h-[4.5rem]">
                            {{ $exercise->description }}
                        </p>
                        
                        <a href="{{ route('respiration.show', $exercise->id) }}" class="inline-flex items-center justify-center w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-cesi-green transition-all duration-300 group/btn shadow-lg shadow-slate-200 hover:shadow-green-500/20">
                            Commencer
                            <svg class="w-5 h-5 ml-2 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Call to Action -->
            <div class="mt-24 relative overflow-hidden bg-slate-900 rounded-[3rem] p-8 sm:p-16 text-center text-white shadow-2xl">
                <div class="absolute top-0 left-0 w-64 h-64 bg-cesi-green/20 rounded-full -ml-32 -mt-32 blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full -mr-48 -mb-48 blur-3xl"></div>
                
                <div class="relative max-w-3xl mx-auto">
                    <h2 class="text-3xl sm:text-5xl font-extrabold mb-6 leading-tight">Créez votre propre rythme.</h2>
                    <p class="text-slate-400 text-lg mb-10 leading-relaxed">
                        Chaque personne est différente. En créant un compte, personnalisez vos temps d'inspiration et d'expiration pour une expérience parfaitement adaptée à vos besoins.
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-cesi-green text-white font-bold text-lg rounded-2xl shadow-xl hover:bg-green-400 hover:scale-105 transition-all duration-300">
                        Ouvrir mon Espace Zen
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-12 text-center text-slate-400 text-sm">
        &copy; {{ date('Y') }} CesiZen — Conçu pour votre bien-être.
    </footer>

</body>
</html>
