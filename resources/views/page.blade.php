<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $page->title }}
        </h2>
    </x-slot>

    <div class="py-10 sm:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('informations') }}" class="text-cesi-green font-bold flex items-center hover:underline">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour aux articles
                </a>
            </div>
            
            <article class="bg-white p-6 sm:p-10 rounded-2xl sm:rounded-3xl shadow-lg border-l-4 sm:border-l-8 border-cesi-yellow">
                <div class="flex items-center space-x-2 mb-4">
                    <span class="px-3 py-1 bg-cesi-green/10 text-cesi-green rounded-full text-xs font-bold uppercase tracking-wider">
                        Par {{ $page->author ? $page->author->name : 'Administrateur' }}
                    </span>
                    <span class="text-gray-400 text-xs">•</span>
                    <span class="text-gray-400 text-xs">{{ $page->created_at->format('d/m/Y') }}</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-cesi-green mb-6">{{ $page->title }}</h2>
                
                <div class="prose max-w-none text-gray-600 text-base sm:text-lg leading-relaxed">
                    {!! nl2br(e($page->content)) !!}
                </div>
            </article>

            @guest
            <div class="mt-12 sm:mt-16 text-center">
                <a href="{{ route('public.exercises') }}" class="inline-flex items-center px-6 py-3 sm:px-8 sm:py-4 bg-cesi-green text-white font-bold text-base sm:text-lg rounded-xl shadow-lg hover:bg-green-700 transition transform hover:scale-105">
                    Pratiquer un exercice maintenant
                </a>
            </div>
            @endguest

        </div>
    </div>
</x-app-layout>
