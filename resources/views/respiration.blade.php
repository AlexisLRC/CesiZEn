<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 hover:underline">Tableau de bord</a>
                @else
                    <a href="{{ route('public.exercises') }}" class="text-gray-400 hover:text-gray-600 hover:underline">Exercices libres</a>
                @endauth
                <span class="mx-2">/</span>
                {{ $exercise->name }}
            </h2>
    </x-slot>

    <div class="py-12 flex flex-col items-center justify-center min-h-[80vh]" 
         x-data="breathLogic({{ $exercise->duration_inhale }}, {{ $exercise->duration_hold }}, {{ $exercise->duration_exhale }})">
        
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-cesi-green mb-2" x-text="instruction">Prêt ?</h1>
            <p class="text-gray-500">Suivez le rythme du cercle</p>
        </div>

        <div class="relative flex items-center justify-center w-96 h-96">
            <div class="absolute w-64 h-64 bg-green-100 rounded-full animate-pulse"></div>
            
            <div 
                class="rounded-full bg-cesi-green shadow-xl flex items-center justify-center text-white text-2xl font-bold transition-all ease-in-out"
                :class="{'bg-cesi-yellow': instruction === 'Bloquez...'}"
                :style="`width: ${size}px; height: ${size}px; transition-duration: ${transitionTime}s`"
            >
                <span x-show="running" x-text="timer" class="text-3xl"></span>
            </div>
        </div>

        <div class="mt-12 flex gap-4">
            <button 
                @click="start()" 
                x-show="!running"
                class="px-8 py-4 bg-cesi-green text-white text-xl font-bold rounded-xl shadow-lg hover:bg-green-700 transition transform hover:scale-105"
            >
                ▶ Commencer
            </button>

            <button 
                @click="stop()" 
                x-show="running"
                class="px-8 py-4 bg-white border-2 border-red-400 text-red-500 text-xl font-bold rounded-xl hover:bg-red-50 transition"
            >
                ⏹ Arrêter
            </button>
        </div>

    </div>

    <script>
        function breathLogic(inhale, hold, exhale) {
            return {
                running: false,
                instruction: 'Prêt ?',
                size: 150, // Taille de départ
                transitionTime: 0.5,
                timer: 0,
                interval: null,
                countdownParams: null,

                start() {
                    if(this.running) return;
                    this.running = true;
                    this.cycle();
                },

                stop() {
                    this.running = false;
                    this.instruction = 'Exercice terminé';
                    this.size = 150;
                    this.transitionTime = 0.5;
                    this.timer = 0;
                    clearTimeout(this.interval);
                    clearInterval(this.countdownParams);
                },

                cycle() {
                    if(!this.running) return;

                    // 1. INSPIRATION
                    this.instruction = 'Inspirez...';
                    this.transitionTime = inhale;
                    this.size = 350; // Taille max
                    this.startTimer(inhale);
                    
                    this.interval = setTimeout(() => {
                        // 2. APNÉE (Optionnelle)
                        if (hold > 0) {
                            this.instruction = 'Bloquez...';
                            this.transitionTime = 0; // Pas de changement de taille
                            this.startTimer(hold);
                            setTimeout(() => {
                                this.exhalePhase(exhale);
                            }, hold * 1000);
                        } else {
                            this.exhalePhase(exhale);
                        }
                    }, inhale * 1000);
                },

                exhalePhase(duration) {
                    if(!this.running) return;
                    // 3. EXPIRATION
                    this.instruction = 'Expirez...';
                    this.transitionTime = duration;
                    this.size = 150; // Retour taille min
                    this.startTimer(duration);

                    setTimeout(() => {
                        this.cycle(); // Boucle infinie
                    }, duration * 1000);
                },

                startTimer(duration) {
                    clearInterval(this.countdownParams);
                    this.timer = duration;
                    this.countdownParams = setInterval(() => {
                        if(this.timer > 0) this.timer--;
                    }, 1000);
                }
            }
        }
    </script>
</x-app-layout>