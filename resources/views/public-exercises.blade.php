<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exercices de Respiration') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12 bg-cover bg-center bg-no-repeat bg-fixed min-h-screen" style="background-image: linear-gradient(rgba(249, 250, 251, 0.8), rgba(249, 250, 251, 0.8)), url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @auth
                <div class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-sm rounded-xl mb-6 border-l-4 border-cesi-green">
                    <div class="p-4 sm:p-6 text-gray-900 text-sm sm:text-base">
                        Bonjour <strong>{{ Auth::user()->name }}</strong> ! Prêt à vous détendre aujourd'hui ?
                    </div>
                </div>
            @endauth

            <h3 class="text-lg font-bold text-cesi-green mb-4 px-2 uppercase tracking-wide">Nos Exercices Guidés</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8 sm:mb-12">
                @foreach($exercises as $exercise)
                <div class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-lg rounded-xl hover:shadow-2xl transition duration-300 border-l-4 border-cesi-green flex flex-col h-full">
                    <div class="p-5 sm:p-6 flex flex-col h-full">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-lg sm:text-xl font-bold text-gray-800">{{ $exercise->name }}</h4>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-2 py-0.5 bg-green-50 text-cesi-green text-[10px] font-bold uppercase rounded-full border border-green-100">{{ $exercise->duration_inhale }}s - {{ $exercise->duration_hold }}s - {{ $exercise->duration_exhale }}s</span>
                        </div>
                        <p class="text-gray-600 text-xs sm:text-sm mb-6 flex-grow">{{ $exercise->description }}</p>
                        <a href="{{ route('respiration.show', $exercise->id) }}" class="block w-full text-center bg-cesi-green text-white font-bold py-2.5 rounded-lg hover:bg-green-700 transition">Lancer la séance</a>
                    </div>
                </div>
                @endforeach
            </div>

            @auth
                <hr class="mb-6 sm:mb-8 border-gray-300">
                <h3 class="text-lg font-bold text-cesi-yellow mb-4 px-2 uppercase tracking-wide">Mon Espace Personnel</h3>

                @php $myExercise = \App\Models\Exercise::where('user_id', Auth::id())->first(); @endphp
                
                <div class="bg-white/90 backdrop-blur-sm p-5 sm:p-6 shadow-lg rounded-xl border-t-4 border-cesi-yellow max-w-full sm:max-w-md">
                    @if($myExercise)
                        <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">Mon Exercice</h4>
                        <p class="text-gray-600 text-xs sm:text-sm mb-4">Rythme : {{ $myExercise->duration_inhale }}s - {{ $myExercise->duration_hold }}s - {{ $myExercise->duration_exhale }}s</p>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('respiration.show', $myExercise->id) }}" class="flex-1 text-center bg-cesi-yellow text-white font-bold py-2 rounded-lg hover:bg-yellow-500 transition">Lancer</a>
                            <a href="{{ route('personal.edit') }}" class="px-4 py-2 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 text-center text-sm sm:text-base">Modifier</a>
                        </div>
                    @else
                        <p class="text-gray-600 text-xs sm:text-sm mb-4">Vous n'avez pas encore défini votre exercice sur mesure.</p>
                        <a href="{{ route('personal.edit') }}" class="block w-full text-center bg-cesi-yellow text-white font-bold py-2 rounded-lg hover:bg-yellow-500 transition">Créer Mon Exercice</a>
                    @endif  
                </div>
            @else
                <!-- Guest CTA Modern -->
                <div class="mt-16 bg-white/90 backdrop-blur-sm rounded-[2.5rem] p-8 sm:p-12 text-center shadow-2xl border border-white relative overflow-hidden">
                    <div class="absolute -top-24 -left-24 w-64 h-64 bg-cesi-green/5 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-cesi-yellow/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 max-w-2xl mx-auto">
                        <h2 class="text-3xl font-extrabold mb-4 text-gray-900 tracking-tight">Voulez-vous personnaliser votre expérience ?</h2>
                        <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                            Chaque respiration est unique. Rejoignez <strong>CesiZen</strong> pour créer votre propre rythme et suivre vos progrès au quotidien.
                        </p>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-cesi-green text-white font-bold text-lg rounded-2xl hover:bg-green-600 transition duration-300 shadow-xl shadow-green-200 hover:scale-105 transform">
                            Créer mon compte gratuitement
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>