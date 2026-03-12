<x-app-layout>
    <style>
        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
        .breathing-circle {
            background: radial-gradient(circle at center, #10b981 0%, #059669 100%);
            box-shadow: 0 10px 40px -10px rgba(16, 185, 129, 0.5);
        }
        .breathing-circle.holding {
            background: radial-gradient(circle at center, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 10px 40px -10px rgba(245, 158, 11, 0.5);
        }
        .zen-bg {
            background: radial-gradient(circle at top right, #f0fdf4 0%, #ffffff 100%);
        }
    </style>

    <div class="zen-bg min-h-screen pt-6 pb-12 px-4" 
         x-data="respirationApp({{ $exercise->duration_inhale }}, {{ $exercise->duration_hold }}, {{ $exercise->duration_exhale }})">
        
        <div class="max-w-4xl mx-auto">
            <!-- Header Zen -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-4">
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="p-2 bg-white rounded-full shadow-sm hover:shadow-md transition">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('public.exercises') }}" class="p-2 bg-white rounded-full shadow-sm hover:shadow-md transition">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                    @endauth
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-800">{{ $exercise->name }}</h2>
                        <p class="text-slate-500 text-sm">Respiration guidée</p>
                    </div>
                </div>

                <div x-show="running" class="bg-white px-6 py-2 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3">
                    <div class="w-2 h-2 bg-red-500 rounded-full animate-ping"></div>
                    <span class="font-mono text-2xl font-bold text-slate-700" x-text="formattedTime"></span>
                </div>
            </div>

            <!-- Area d'animation -->
            <div class="flex flex-col items-center justify-center py-12">
                <div class="text-center mb-12 h-24 flex flex-col justify-center">
                    <h1 class="text-4xl sm:text-6xl font-black text-slate-900 tracking-tight transition-all duration-500" 
                        :class="{'scale-110': instruction !== 'Prêt ?'}"
                        x-text="instruction">
                        Prêt ?
                    </h1>
                    <p class="text-slate-400 mt-4 text-lg font-medium" x-show="!running">Installez-vous confortablement</p>
                </div>

                <!-- Le Cercle -->
                <div class="relative flex items-center justify-center transition-all duration-1000" :class="{'scale-90 opacity-40': !running}">
                    <!-- Anneau externe pulse -->
                    <div class="absolute rounded-full border border-green-100 transition-all duration-1000"
                         :style="`width: ${size + 60}px; height: ${size + 60}px;`"
                         x-show="running"></div>
                    
                    <div 
                        class="breathing-circle rounded-full flex flex-col items-center justify-center text-white transition-all ease-in-out relative z-10"
                        :class="{'holding': instruction === 'Bloquez...'}"
                        :style="`width: ${size}px; height: ${size}px; transition-duration: ${transitionTime}s`"
                    >
                        <div x-show="running" class="flex flex-col items-center">
                            <span x-text="timer" class="text-5xl font-black"></span>
                            <span class="text-xs uppercase tracking-[0.2em] opacity-70 font-bold mt-1">secondes</span>
                        </div>
                        
                        <!-- Glow effect -->
                        <div class="absolute inset-0 rounded-full bg-white opacity-20 blur-2xl scale-75" x-show="running && instruction === 'Inspirez...'"></div>
                    </div>
                </div>

                <!-- Contrôles -->
                <div class="mt-20 w-full max-w-md">
                    <div x-show="!running" class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 space-y-6">
                        @auth
                            <div>
                                <label class="block text-center text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Durée de la séance</label>
                                <div class="flex items-center justify-center gap-6">
                                    <button @click="if(sessionMinutes > 1) sessionMinutes--" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 transition">-</button>
                                    <div class="text-center">
                                        <span class="text-5xl font-black text-slate-800" x-text="sessionMinutes"></span>
                                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-tighter">minutes</span>
                                    </div>
                                    <button @click="sessionMinutes++" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 transition">+</button>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-slate-500 font-medium mb-2">Séance de respiration</p>
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-full text-slate-700 font-bold">
                                    <svg class="w-5 h-5 text-cesi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    5 minutes
                                </div>
                            </div>
                        @endauth

                        <button @click="startSession()" class="w-full bg-slate-900 text-white font-extrabold py-5 rounded-3xl shadow-2xl shadow-slate-900/20 hover:bg-cesi-green transition-all duration-300 transform hover:scale-[1.02] active:scale-95 text-xl">
                            Démarrer la séance
                        </button>
                    </div>

                    <div x-show="running" class="flex justify-center">
                        <button @click="stopSession(false)" class="group flex items-center gap-3 px-8 py-4 bg-white text-red-500 font-bold rounded-2xl shadow-lg border border-red-50 hover:bg-red-50 transition-all duration-300">
                            <div class="w-3 h-3 bg-red-500 rounded-sm"></div>
                            Arrêter l'exercice
                        </button>
                    </div>
                </div>
            </div>

            <!-- Conseils Zen -->
            <div x-show="!running" class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white/50 p-6 rounded-3xl border border-white flex flex-col items-center text-center">
                    <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-3.682A14.059 14.059 0 0110 11.83a14.059 14.059 0 014 4.352m-1.747 5.682A14.059 14.059 0 0016 11.829c0-1.724-.31-3.376-.878-4.905m-4.07-2.04c-.659-.112-1.33-.171-2.015-.171-4.418 0-8 3.582-8 8 0 2.209.895 4.209 2.343 5.657L12 11z"></path></svg>
                    </div>
                    <h4 class="font-bold text-slate-700 mb-1">Position</h4>
                    <p class="text-xs text-slate-500">Dos droit, épaules relâchées et pieds à plat.</p>
                </div>
                <div class="bg-white/50 p-6 rounded-3xl border border-white flex flex-col items-center text-center">
                    <div class="w-10 h-10 bg-purple-50 text-purple-500 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <h4 class="font-bold text-slate-700 mb-1">Regard</h4>
                    <p class="text-xs text-slate-500">Fermez les yeux ou fixez un point neutre.</p>
                </div>
                <div class="bg-white/50 p-6 rounded-3xl border border-white flex flex-col items-center text-center">
                    <div class="w-10 h-10 bg-green-50 text-green-500 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h4 class="font-bold text-slate-700 mb-1">Bienfaits</h4>
                    <p class="text-xs text-slate-500">Réduit instantanément le cortisol (stress).</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('respirationApp', (inhale, hold, exhale) => ({
                running: false,
                instruction: 'Prêt ?',
                baseSize: window.innerWidth < 640 ? 140 : 180,
                maxSize: window.innerWidth < 640 ? 260 : 360,
                size: window.innerWidth < 640 ? 140 : 180,
                transitionTime: 0.5,
                timer: 0,
                currentTimeout: null,
                countdownParams: null,
                sessionMinutes: 5,
                sessionSecondsRemaining: 0,
                sessionInterval: null,

                init() {
                    window.addEventListener('resize', () => {
                        this.baseSize = window.innerWidth < 640 ? 140 : 180;
                        this.maxSize = window.innerWidth < 640 ? 260 : 360;
                        if (!this.running) this.size = this.baseSize;
                    });
                },

                get formattedTime() {
                    let m = Math.floor(this.sessionSecondsRemaining / 60);
                    let s = this.sessionSecondsRemaining % 60;
                    return (m < 10 ? "0" + m : m) + ":" + (s < 10 ? "0" + s : s);
                },

                startSession() {
                    if (this.running) return;
                    let mins = parseInt(this.sessionMinutes);
                    if (isNaN(mins) || mins < 1) mins = 5;
                    this.sessionMinutes = mins;
                    this.sessionSecondsRemaining = mins * 60;
                    this.running = true;
                    this.cycle();
                    this.sessionInterval = setInterval(() => {
                        this.sessionSecondsRemaining--;
                        if (this.sessionSecondsRemaining <= 0) {
                            this.stopSession(true);
                        }
                    }, 1000);
                },

                stopSession(completedNaturally) {
                    // Calcul du temps passé
                    let durationSeconds = (this.sessionMinutes * 60) - this.sessionSecondsRemaining;
                    
                    this.running = false;
                    this.instruction = 'Séance terminée';
                    this.size = this.baseSize;
                    this.transitionTime = 0.5;
                    this.timer = 0;
                    clearTimeout(this.currentTimeout);
                    clearInterval(this.countdownParams);
                    clearInterval(this.sessionInterval);

                    // Envoi des statistiques au serveur (si connecté)
                    @auth
                    fetch('{{ route('session.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            exercise_id: {{ $exercise->id }},
                            duration_seconds: durationSeconds,
                            target_duration_seconds: this.sessionMinutes * 60,
                            is_completed: completedNaturally
                        })
                    });
                    @endauth

                    if (completedNaturally) {
                        setTimeout(() => { alert("✨ Séance terminée ! Prenez un instant pour ressentir les bienfaits."); }, 100);
                    }
                },

                cycle() {
                    if(!this.running) return;
                    this.instruction = 'Inspirez...';
                    this.transitionTime = inhale;
                    this.size = this.maxSize;
                    this.startTimer(inhale);
                    this.currentTimeout = setTimeout(() => {
                        if(!this.running) return;
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
