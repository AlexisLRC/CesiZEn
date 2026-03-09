<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CesiZen - Santé Mentale</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-50 text-cesi-dark bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), url('https://images.unsplash.com/photo-1506126613408-eca07ce68773?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        
        <div class="relative flex justify-between items-center p-6 bg-white/90 shadow-md backdrop-blur-sm">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12">
                <span class="text-2xl font-bold text-cesi-green tracking-wide">CESI<span class="text-cesi-yellow">ZEN</span></span>
            </div>

            <div>
                @if (Route::has('login'))
                    <nav class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-cesi-green text-white rounded-lg hover:bg-green-700 transition">
                                Mon Espace
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-cesi-green font-semibold hover:underline">
                                Connexion
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-cesi-green text-white rounded-lg hover:bg-green-700 transition shadow-lg">
                                    Créer un compte
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>

        <div class="min-h-[80vh] flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-5xl font-extrabold text-cesi-green mb-6">
                L'application de votre <br>
                <span class="text-cesi-yellow">Santé Mentale</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mb-10">
                Un outil simple, gratuit et sécurisé pour apprendre à gérer votre stress, 
                suivre vos émotions et pratiquer la cohérence cardiaque.
            </p>

            <div class="flex gap-6">
                <a href="{{ route('public.exercises') }}" class="px-8 py-4 bg-cesi-green text-white text-lg font-bold rounded-xl shadow-xl hover:scale-105 transition transform">
                    Commencer maintenant
                </a>
                <a href="{{ route('informations') }}" class="px-8 py-4 bg-white text-cesi-green border-2 border-cesi-green text-lg font-bold rounded-xl hover:bg-green-50 transition">
                    En savoir plus
                </a>
            </div>
        </div>

    </body>
</html>