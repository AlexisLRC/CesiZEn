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
        
        <div class="relative flex flex-col sm:flex-row justify-between items-center p-4 sm:p-6 bg-white/90 shadow-md backdrop-blur-sm gap-4">
            <div class="flex items-center gap-3 sm:gap-4">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 sm:h-12">
                <span class="text-xl sm:text-2xl font-bold text-cesi-green tracking-wide">CESI<span class="text-cesi-yellow">ZEN</span></span>
            </div>

            <div class="w-full sm:w-auto">
                @if (Route::has('login'))
                    <nav class="flex justify-center sm:justify-end gap-2 sm:gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-cesi-green text-white rounded-lg hover:bg-green-700 transition text-sm sm:text-base">
                                Mon Espace
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-3 py-2 text-cesi-green font-semibold hover:underline text-sm sm:text-base">
                                Connexion
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-cesi-green text-white rounded-lg hover:bg-green-700 transition shadow-lg text-sm sm:text-base">
                                    Créer un compte
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>

        <div class="min-h-[70vh] sm:min-h-[80vh] flex flex-col items-center justify-center text-center px-4 py-12">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-cesi-green mb-4 sm:mb-6 leading-tight">
                L'application de votre <br>
                <span class="text-cesi-yellow">Santé Mentale</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mb-8 sm:mb-10">
                Un outil simple, gratuit et sécurisé pour apprendre à gérer votre stress, 
                suivre vos émotions et pratiquer la cohérence cardiaque.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 w-full max-w-xs sm:max-w-none items-center justify-center">
                <a href="{{ route('public.exercises') }}" style="background-color: #2563eb;" class="w-full sm:w-auto px-6 py-3 sm:px-8 sm:py-4 text-white text-base sm:text-lg font-bold rounded-xl shadow-xl hover:scale-105 transition transform text-center">
                    Commencer maintenant
                </a>
                <a href="{{ route('informations') }}" class="w-full sm:w-auto px-6 py-3 sm:px-8 sm:py-4 bg-white text-cesi-green border-2 border-cesi-green text-base sm:text-lg font-bold rounded-xl hover:bg-green-50 transition text-center">
                    En savoir plus
                </a>
            </div>
        </div>

    </body>
</html>