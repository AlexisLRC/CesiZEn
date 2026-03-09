<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exercices en libre accès - CesiZen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    <div class="w-full bg-white shadow-sm border-b border-gray-100 px-4 sm:px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
        <a href="{{ route('home') }}">
            <img src="{{ asset('logo.png') }}" class="h-8 sm:h-10 w-auto" alt="Logo CesiZen">
        </a>
        <div class="flex items-center gap-3 sm:gap-4">
            <a href="{{ route('login') }}" class="font-bold text-gray-500 hover:text-cesi-green transition text-sm sm:text-base">Connexion</a>
            <a href="{{ route('register') }}" class="px-4 py-2 sm:px-5 sm:py-2 bg-cesi-green text-white font-bold rounded-lg hover:bg-green-700 transition shadow-md text-sm sm:text-base text-center">Créer un compte</a>
        </div>
    </div>

    <div class="py-10 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-10 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-cesi-green mb-4">Exercices en libre accès</h2>
                <p class="text-gray-500 text-lg sm:text-xl max-w-2xl mx-auto">Prenez quelques minutes pour vous détendre avec nos exercices de respiration guidés. Aucune inscription n'est requise.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($exercises as $exercise)
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl hover:shadow-2xl transition duration-300 border-t-4 border-cesi-green flex flex-col">
                    <div class="p-6 sm:p-8 flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $exercise->name }}</h4>
                        </div>
                        <p class="text-gray-600 mb-6 sm:mb-8 flex-1 text-sm sm:text-base">
                            {{ $exercise->description }}
                        </p>
                        
                        <a href="{{ route('respiration.show', $exercise->id) }}" class="block w-full text-center bg-green-50 text-cesi-green border-2 border-cesi-green font-bold py-3 rounded-xl hover:bg-cesi-green hover:text-white transition">
                            Lancer la séance
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 sm:mt-20 bg-white p-6 sm:p-10 rounded-2xl shadow-md text-center border-l-4 sm:border-l-8 border-cesi-yellow">
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Envie d'aller plus loin ?</h3>
                <p class="text-gray-600 text-base sm:text-lg mb-6 sm:mb-8 max-w-3xl mx-auto">Créez un compte gratuitement pour configurer <strong>votre propre exercice sur mesure</strong>, suivre vos émotions et enregistrer vos résultats.</p>
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 sm:px-8 sm:py-4 bg-cesi-yellow text-white font-bold text-base sm:text-lg rounded-xl shadow-lg hover:bg-yellow-500 transition transform hover:scale-105">
                    Créer mon Espace Zen gratuit
                </a>
            </div>

        </div>
    </div>

</body>
</html>