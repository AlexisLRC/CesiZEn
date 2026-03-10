<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comprendre sa santé mentale') }}
        </h2>
    </x-slot>

    @php
        // Liste d'images thématiques (Zen, Nature, Santé Mentale)
        $themes = ['meditation', 'nature', 'zen', 'calm', 'forest', 'green', 'relaxation', 'peaceful'];
        
        // On prépare les pages avec une image aléatoire pour le JS
        $preparedPages = $pages->map(function($p) use ($themes) {
            $keyword = $themes[$p->id % count($themes)];
            return array_merge($p->toArray(), [
                'author_name' => $p->author ? $p->author->name : 'Administrateur',
                'image_url' => "https://images.unsplash.com/photo-" . (1500000000000 + ($p->id * 1000000)) . "?q=80&w=800&auto=format&fit=crop&sig=" . $p->id . "&" . $keyword,
                // On utilise des fallbacks plus sûrs avec source.unsplash
                'fallback_image' => "https://source.unsplash.com/featured/800x600?{$keyword}&sig={$p->id}",
                // En fait, Unsplash a changé son API, on va utiliser des URLs directes thématiques robustes
                'img' => "https://images.unsplash.com/photo-1506126613408-eca07ce68773?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" // Défaut
            ]);
        });
        
        // Tableau d'images de secours thématiques (pour éviter les liens cassés)
        $themeImages = [
            "https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80", // Yoga/Zen
            "https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=800&q=80", // Nature
            "https://images.unsplash.com/photo-1518199266791-5375a83190b7?auto=format&fit=crop&w=800&q=80", // Coeur/Soin
            "https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=800&q=80", // Bureau/Lecture
            "https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=800&q=80", // Relaxation
            "https://images.unsplash.com/photo-1528712306091-ed0763094c98?auto=format&fit=crop&w=800&q=80"  // Méditation
        ];
    @endphp

    <div class="py-10 sm:py-16 bg-gray-50" x-data="{ 
        search: '',
        baseUrl: '{{ url('/page') }}/',
        pages: {{ $preparedPages->map(function($p, $index) use ($themeImages) {
            $p['image_url'] = $themeImages[$index % count($themeImages)];
            return $p;
        })->toJson() }},
        get filteredPages() {
            if (!this.search) return this.pages;
            return this.pages.filter(p => 
                p.title.toLowerCase().includes(this.search.toLowerCase()) || 
                p.content.toLowerCase().includes(this.search.toLowerCase())
            )
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if (session('status'))
                <div class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-cesi-green mb-2">Comprendre sa santé mentale</h2>
                    <p class="text-gray-500 text-lg">Apprenez-en plus sur le stress, la cohérence cardiaque et les méthodes de relaxation.</p>
                </div>
                
                @auth
                    <a href="{{ route('article.create') }}" class="inline-flex items-center px-6 py-3 bg-cesi-yellow text-gray-800 font-bold rounded-xl shadow-lg hover:bg-yellow-400 transition transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Proposer un article
                    </a>
                @endauth
            </div>

            <!-- Barre de Recherche -->
            <div class="max-w-xl mx-auto mb-12">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" x-model="search" placeholder="Rechercher un article..." class="block w-full pl-10 pr-3 py-4 border border-transparent leading-5 bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cesi-green focus:border-transparent sm:text-sm rounded-2xl shadow-sm transition">
                </div>
            </div>

            <!-- Carousel des articles à la une (si pas de recherche en cours) -->
            <div x-show="search.length === 0 && pages.length > 0" class="mb-16">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-2 h-8 bg-cesi-yellow rounded-full mr-3"></span>
                    À la une
                </h3>
                
                <div class="relative overflow-hidden rounded-3xl shadow-2xl" x-data="{ 
                    activeSlide: 0,
                    slidesCount: {{ min($pages->count(), 3) }},
                    next() { this.activeSlide = (this.activeSlide + 1) % this.slidesCount },
                    prev() { this.activeSlide = (this.activeSlide - 1 + this.slidesCount) % this.slidesCount }
                }">
                    <div class="flex transition-transform duration-700 ease-in-out h-[400px] sm:h-[500px]" :style="`transform: translateX(-${activeSlide * 100}%)`">
                        @foreach($pages->take(3) as $index => $featured)
                        <div class="w-full flex-shrink-0 relative">
                            <!-- Image de fond -->
                            <img src="{{ $themeImages[$index % count($themeImages)] }}" alt="{{ $featured->title }}" class="absolute inset-0 w-full h-full object-cover">
                            <!-- Overlay dégradé -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                            
                            <div class="absolute inset-0 p-8 sm:p-16 flex flex-col justify-end text-white">
                                <div class="relative z-10 max-w-3xl">
                                    <div class="flex items-center space-x-2 mb-4">
                                        <span class="px-3 py-1 bg-cesi-green text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
                                            Par {{ $featured->author ? $featured->author->name : 'Administrateur' }}
                                        </span>
                                    </div>
                                    <h4 class="text-3xl sm:text-5xl font-extrabold mb-4 drop-shadow-lg leading-tight">{{ $featured->title }}</h4>
                                    <p class="text-gray-100 opacity-90 text-lg sm:text-xl mb-8 line-clamp-2 drop-shadow-md">
                                        {{ Str::limit(strip_tags($featured->content), 150) }}
                                    </p>
                                    <a href="{{ route('page.show', $featured->slug) }}" class="inline-flex items-center px-8 py-4 bg-white text-cesi-green font-bold text-lg rounded-2xl hover:bg-cesi-yellow hover:text-gray-900 transition transform hover:scale-105 shadow-xl">
                                        Lire l'article complet
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l7-7m-7 7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($pages->count() > 1)
                    <!-- Contrôles -->
                    <button @click="prev()" class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/90 p-4 rounded-2xl text-white hover:text-cesi-green backdrop-blur-md transition shadow-lg group">
                        <svg class="w-6 h-6 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="next()" class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/90 p-4 rounded-2xl text-white hover:text-cesi-green backdrop-blur-md transition shadow-lg group">
                        <svg class="w-6 h-6 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    
                    <!-- Indicateurs -->
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-3">
                        <template x-for="i in slidesCount" :key="i">
                            <button @click="activeSlide = i-1" :class="activeSlide === i-1 ? 'w-10 bg-cesi-yellow' : 'w-3 bg-white/50'" class="h-3 rounded-full transition-all duration-300"></button>
                        </template>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Grille des articles (Filtrée) -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-2 h-8 bg-cesi-green rounded-full mr-3"></span>
                    <span x-text="search.length > 0 ? 'Résultats de recherche' : 'Tous nos articles'"></span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <template x-for="page in filteredPages" :key="page.id">
                        <a :href="baseUrl + page.slug" class="group bg-white rounded-3xl shadow-sm hover:shadow-2xl border border-gray-100 overflow-hidden transition-all duration-500 transform hover:-translate-y-2 flex flex-col h-full">
                            <!-- Image de la carte -->
                            <div class="h-52 overflow-hidden relative">
                                <img :src="page.image_url" :alt="page.title" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                            </div>
                            
                            <div class="p-8 flex flex-col h-full">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-bold text-cesi-green uppercase tracking-widest bg-green-50 px-3 py-1 rounded-full" x-text="page.author_name"></span>
                                    <span class="text-xs text-gray-400 font-medium" x-text="new Date(page.created_at).toLocaleDateString('fr-FR')"></span>
                                </div>
                                <h4 class="text-xl font-extrabold text-gray-800 mb-4 group-hover:text-cesi-green transition" x-text="page.title"></h4>
                                <p class="text-gray-500 line-clamp-3 mb-6 flex-grow leading-relaxed" x-text="page.content.replace(/<[^>]*>?/gm, '').substring(0, 120) + '...'"></p>
                                <div class="flex items-center text-cesi-green font-bold text-sm mt-auto group-hover:underline decoration-2 underline-offset-4">
                                    Consulter l'article
                                    <svg class="w-5 h-5 ml-2 transition-transform duration-300 group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>

                <!-- Message si aucun résultat -->
                <div x-show="filteredPages.length === 0" class="text-center py-24 bg-white rounded-[3rem] shadow-inner border-4 border-dashed border-gray-100">
                    <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <p class="text-gray-400 text-xl font-medium">Aucun article ne correspond à votre recherche.</p>
                    <button @click="search = ''" class="mt-4 text-cesi-green font-bold hover:underline">Réinitialiser la recherche</button>
                </div>
            </div>

            @guest
            <div class="mt-24 text-center">
                <div class="bg-cesi-green/5 p-12 rounded-[3rem] inline-block max-w-2xl">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Prêt à passer à l'action ?</h3>
                    <p class="text-gray-600 mb-8">Utilisez nos outils guidés pour mettre en pratique ce que vous avez appris.</p>
                    <a href="{{ route('public.exercises') }}" class="inline-flex items-center px-10 py-5 bg-cesi-green text-white font-extrabold text-xl rounded-2xl shadow-xl hover:bg-green-700 transition transform hover:scale-105">
                        Lancer un exercice de respiration
                        <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </a>
                </div>
            </div>
            @endguest

        </div>
    </div>
</x-app-layout>
