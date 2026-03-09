<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>En savoir plus - CesiZen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    <div class="w-full bg-white shadow-sm border-b border-gray-100 px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}">
            <img src="{{ asset('logo.png') }}" class="h-10 w-auto" alt="Logo CesiZen">
        </a>
        <div class="flex items-center gap-4">
            <a href="{{ route('public.exercises') }}" class="font-bold text-gray-500 hover:text-cesi-green transition mr-4">Exercices libres</a>
            @auth
                <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-cesi-green text-white font-bold rounded-lg hover:bg-green-700 transition shadow-md">Mon Espace</a>
            @else
                <a href="{{ route('login') }}" class="font-bold text-gray-500 hover:text-cesi-green transition">Connexion</a>
                <a href="{{ route('register') }}" class="px-5 py-2 bg-cesi-green text-white font-bold rounded-lg hover:bg-green-700 transition shadow-md">Créer un compte</a>
            @endauth
        </div>
    </div>

    <div class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-cesi-green mb-4">Comprendre sa santé mentale</h2>
                <p class="text-gray-500 text-xl">Apprenez-en plus sur le stress, la cohérence cardiaque et les méthodes de relaxation.</p>
            </div>

            <div class="space-y-12">
                @forelse($pages as $page)
                    <div class="bg-white p-10 rounded-3xl shadow-lg border-l-8 border-cesi-yellow">
                        <h3 class="text-3xl font-bold text-gray-800 mb-6">{{ $page->title }}</h3>
                        
                        <div class="prose max-w-none text-gray-600 text-lg leading-relaxed">
                            {!! nl2br(e($page->content)) !!}
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 bg-white p-10 rounded-xl shadow">
                        <p>Les articles informatifs sont en cours de rédaction. Revenez très vite !</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-16 text-center">
                <a href="{{ route('public.exercises') }}" class="inline-flex items-center px-8 py-4 bg-cesi-green text-white font-bold text-lg rounded-xl shadow-lg hover:bg-green-700 transition transform hover:scale-105">
                    Pratiquer un exercice maintenant
                </a>
            </div>

        </div>
    </div>

</body>
</html>