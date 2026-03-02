<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Espace Zen') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    Bonjour <strong>{{ Auth::user()->name }}</strong> ! Prêt à vous détendre aujourd'hui ?
                </div>
            </div>

            <h3 class="text-lg font-bold text-cesi-green mb-4 px-2">Exercices de Respiration</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach(\App\Models\Exercise::all() as $exercise)
                <div class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-2xl transition duration-300 border-l-4 border-cesi-yellow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-xl font-bold text-gray-800">{{ $exercise->name }}</h4>
                            <span class="bg-green-100 text-cesi-green py-1 px-3 rounded-full text-xs font-bold">
                                {{ ($exercise->duration_inhale + $exercise->duration_hold + $exercise->duration_exhale) }} sec / cycle
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-6 h-12">
                            {{ $exercise->description ?? 'Un exercice pour apaiser votre mental.' }}
                        </p>
                        
                        <a href="{{ route('respiration.show', $exercise->id) }}" class="block w-full text-center bg-cesi-green text-white font-bold py-2 rounded-lg hover:bg-green-700 transition">
                            Lancer la séance
                        </a>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>