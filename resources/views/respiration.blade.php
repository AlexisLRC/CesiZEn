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

    <div class="py-6 sm:py-12 flex flex-col items-center justify-center min-h-[80vh] px-4" 
         x-data="respirationApp({{ $exercise->duration_inhale }}, {{ $exercise->duration_hold }}, {{ $exercise->duration_exhale }})">
        
        <div class="text-center mb-6 sm:mb-10">
            <h1 class="text-2xl sm:text-4xl font-bold text-cesi-green mb-2" x-text="instruction">Prêt ?</h1>
            <p class="text-gray-500 text-sm sm:text-base">Suivez le rythme du cercle</p>
        </div>

        <div class="relative flex items-center justify-center w-64 h-64 sm:w-96 sm:h-96 transition-opacity duration-1000" :class="{'opacity-50': !running}">
            <div class="absolute w-48 h-48 sm:w-64 sm:h-64 bg-green-100 rounded-full animate-pulse"></div>
            
            <div 
                class="rounded-full bg-cesi-green shadow-xl flex items-center justify-center text-white text-xl sm:text-2xl font-bold transition-all ease-in-out"
                :class="{'bg-cesi-yellow': instruction === 'Bloquez...'}"
                :style="`width: ${size}px; height: ${size}px; transition-duration: ${transitionTime}s`"
            >
                <span x-show="running" x-text="timer" class="text-2xl sm:text-3xl"></span>
            </div>
        </div>

        <div class="max-w-3xl mx-auto bg-white p-6 sm:p-8 mt-8 sm:mt-12 rounded-xl shadow-lg text-center w-full">
    
            <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row justify-center items-center gap-2 sm:gap-4">
                <label class="text-lg sm:text-xl font-bold text-gray-700">Durée de la séance :</label>
                
                <div class="flex items-center gap-2">
                    @auth
                        <input type="number" x-model="sessionMinutes" :disabled="running" min="1" max="120" class="w-20 sm:w-24 text-xl sm:text-2xl border-2 border-cesi-green rounded-lg text-center font-bold focus:ring-cesi-green focus:border-cesi-green disabled:bg-gray-100 disabled:text-gray-400">
                        <span class="text-gray-600 font-bold text-base sm:text-lg">minutes</span>
                    @else
                        <input type="number" x-model="sessionMinutes" disabled class="w-20 sm:w-24 text-xl sm:text-2xl border-gray-300 bg-gray-100 rounded-lg text-center font-bold text-gray-500 cursor-not-allowed">
                        <span class="text-gray-500 font-bold text-base sm:text-lg">minutes <br><span class="text-xs text-gray-400">(Connexion requise)</span></span>
                    @endauth
                </div>
            </div>

            <div x-show="running" class="text-4xl sm:text-6xl font-extrabold text-cesi-green mb-6 sm:mb-8" x-text="formattedTime"></div>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <button x-show="!running" @click="startSession()" class="px-6 py-3 sm:px-8 sm:py-4 bg-cesi-green text-white font-bold text-lg sm:text-xl rounded-xl shadow-lg hover:bg-green-700 transition transform hover:scale-105">
                    ▶ Démarrer la séance
                </button>

                <button x-show="running" @click="stopSession(false)" class="px-6 py-3 sm:px-8 sm:py-4 bg-red-500 text-white font-bold text-lg sm:text-xl rounded-xl shadow-lg hover:bg-red-600 transition">
                    ⏹ Arrêter
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('respirationApp', (inhale, hold, exhale) => ({
                // États de l'animation
                running: false,
                instruction: 'Prêt ?',
                baseSize: window.innerWidth < 640 ? 100 : 150,
                maxSize: window.innerWidth < 640 ? 250 : 350,
                size: window.innerWidth < 640 ? 100 : 150,
                transitionTime: 0.5,
                timer: 0,
                currentTimeout: null,
                countdownParams: null,

                // États de la séance globale (le chronomètre)
                sessionMinutes: 5,
                sessionSecondsRemaining: 0,
                sessionInterval: null,

                init() {
                    window.addEventListener('resize', () => {
                        this.baseSize = window.innerWidth < 640 ? 100 : 150;
                        this.maxSize = window.innerWidth < 640 ? 250 : 350;
                        if (!this.running) this.size = this.baseSize;
                    });
                },

                // Calcule automatiquement l'affichage du temps (ex: 04:59)
                get formattedTime() {
                    let m = Math.floor(this.sessionSecondsRemaining / 60);
                    let s = this.sessionSecondsRemaining % 60;
                    return (m < 10 ? "0" + m : m) + ":" + (s < 10 ? "0" + s : s);
                },

                // DÉMARRER LA SÉANCE
                startSession() {
                    if (this.running) return;

                    // Sécuriser l'entrée de la durée
                    let mins = parseInt(this.sessionMinutes);
                    if (isNaN(mins) || mins < 1) mins = 5;
                    this.sessionMinutes = mins;
                    this.sessionSecondsRemaining = mins * 60;

                    this.running = true;

                    // 1. Lancer le cercle de respiration
                    this.cycle();

                    // 2. Lancer le chronomètre global
                    this.sessionInterval = setInterval(() => {
                        this.sessionSecondsRemaining--;
                        
                        // Si le temps est écoulé
                        if (this.sessionSecondsRemaining <= 0) {
                            this.stopSession(true);
                        }
                    }, 1000);
                },

                // ARRÊTER LA SÉANCE
                stopSession(completedNaturally) {
                    this.running = false;
                    this.instruction = 'Exercice terminé';
                    this.size = this.baseSize;
                    this.transitionTime = 0.5;
                    this.timer = 0;

                    // Tout arrêter
                    clearTimeout(this.currentTimeout);
                    clearInterval(this.countdownParams);
                    clearInterval(this.sessionInterval);

                    if (completedNaturally) {
                        // Un petit délai pour laisser l'interface s'actualiser à 00:00 avant l'alerte
                        setTimeout(() => {
                            alert("✨ Séance terminée ! Prenez un instant pour ressentir les bienfaits.");
                        }, 100);
                    }
                },

                // LA LOGIQUE DE RESPIRATION
                cycle() {
                    if(!this.running) return;

                    // 1. INSPIRATION
                    this.instruction = 'Inspirez...';
                    this.transitionTime = inhale;
                    this.size = this.maxSize;
                    this.startTimer(inhale);
                    
                    this.currentTimeout = setTimeout(() => {
                        if(!this.running) return;

                        // 2. APNÉE
                        if (hold > 0) {
                            this.instruction = 'Bloquez...';
                            this.transitionTime = 0;
                            this.startTimer(hold);
                            this.currentTimeout = setTimeout(() => {
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
                    this.size = this.baseSize;
                    this.startTimer(duration);

                    this.currentTimeout = setTimeout(() => {
                        this.cycle();
                    }, duration * 1000);
                },

                startTimer(duration) {
                    clearInterval(this.countdownParams);
                    this.timer = duration;
                    this.countdownParams = setInterval(() => {
                        if(this.timer > 0) this.timer--;
                    }, 1000);
                }
            }));
        });
    </script>
</x-app-layout>