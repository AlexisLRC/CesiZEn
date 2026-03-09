<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comprendre sa santé mentale') }}
        </h2>
    </x-slot>

    <div class="py-10 sm:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-10 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-cesi-green mb-4">Comprendre sa santé mentale</h2>
                <p class="text-gray-500 text-lg sm:text-xl">Apprenez-en plus sur le stress, la cohérence cardiaque et les méthodes de relaxation.</p>
            </div>

            <div class="space-y-8 sm:space-y-12">
                @forelse($pages as $page)
                    <div class="bg-white p-6 sm:p-10 rounded-2xl sm:rounded-3xl shadow-lg border-l-4 sm:border-l-8 border-cesi-yellow">
                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">{{ $page->title }}</h3>
                        
                        <div class="prose max-w-none text-gray-600 text-base sm:text-lg leading-relaxed">
                            {!! nl2br(e($page->content)) !!}
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 bg-white p-10 rounded-xl shadow">
                        <p>Les articles informatifs sont en cours de rédaction. Revenez très vite !</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 sm:mt-16 text-center">
                <a href="{{ route('public.exercises') }}" class="inline-flex items-center px-6 py-3 sm:px-8 sm:py-4 bg-cesi-green text-white font-bold text-base sm:text-lg rounded-xl shadow-lg hover:bg-green-700 transition transform hover:scale-105">
                    Pratiquer un exercice maintenant
                </a>
            </div>

        </div>
    </div>
</x-app-layout>