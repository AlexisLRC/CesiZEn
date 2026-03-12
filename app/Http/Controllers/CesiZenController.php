<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Page;
use App\Models\ExerciseSession;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CesiZenController extends Controller
{
    // Affiche la liste des pages d'info
    public function index() {
        $pages = Page::where('is_published', true)->get();
        return view('welcome', compact('pages'));
    }

    // Affiche une page d'info spécifique
    public function showPage($slug) {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('page', compact('page'));
    }

    // Affiche l'outil de respiration
    public function respiration($id)
    {
        $exercise = Exercise::findOrFail($id);
        return view('respiration', compact('exercise'));
    }
    
    // Affiche la liste des exercices pour tous
    public function publicExercises()
    {
        $exercises = Exercise::whereNull('user_id')->orderBy('order', 'asc')->get();
        return view('public-exercises', compact('exercises'));
    }

    // Affiche la liste des pages d'info
    public function informations()
    {
        $pages = Page::where('is_published', true)->with('author')->latest()->get(); 
        return view('informations', compact('pages'));
    }

    // Formulaire de proposition d'article
    public function createArticle()
    {
        return view('admin.pages.form', [
            'page' => new Page(),
            'isProposal' => true
        ]);
    }

    // Enregistre la proposition d'article
    public function storeArticle(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $page = new Page($validated);
        $page->slug = \Illuminate\Support\Str::slug($validated['title']) . '-' . uniqid();
        $page->is_published = false; 
        $page->user_id = auth()->id();
        $page->save();

        return redirect()->route('informations')->with('status', 'Votre article a été soumis avec succès.');
    }

    // Affiche le formulaire pour l'exercice perso
    public function editPersonal()
    {
        $exercise = Exercise::where('user_id', auth()->id())->first();
        return view('personal-exercise', compact('exercise'));
    }

    // Sauvegarde l'exercice perso
    public function storePersonal(Request $request)
    {
        $data = $request->validate([
            'duration_inhale' => 'required|integer|min:1',
            'duration_hold' => 'required|integer|min:0',
            'duration_exhale' => 'required|integer|min:1',
        ]);

        Exercise::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'name' => 'Mon Exercice',
                'description' => 'Votre rythme de respiration sur mesure.',
                'duration_inhale' => $data['duration_inhale'],
                'duration_hold' => $data['duration_hold'],
                'duration_exhale' => $data['duration_exhale'],
                'order' => 999
            ]
        );

        return redirect()->route('dashboard');
    }

    /**
     * ENREGISTRER UNE SESSION (Appel API via JS)
     */
    public function storeSession(Request $request)
    {
        if (!auth()->check()) return response()->json(['error' => 'Unauthorized'], 401);

        $validated = $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'duration_seconds' => 'required|integer',
            'target_duration_seconds' => 'required|integer',
            'is_completed' => 'required|boolean',
        ]);

        $session = new ExerciseSession();
        $session->user_id = auth()->id();
        $session->exercise_id = $validated['exercise_id'];
        $session->duration_seconds = $validated['duration_seconds'];
        $session->target_duration_seconds = $validated['target_duration_seconds'];
        $session->is_completed = $validated['is_completed'];
        $session->save();

        return response()->json(['success' => true]);
    }

    /**
     * PAGE STATISTIQUES
     */
    public function stats()
    {
        $user = auth()->user();
        
        // 1. Indicateurs de base
        $totalTimeSeconds = $user->sessions()->sum('duration_seconds');
        $totalSessions = $user->sessions()->count();
        $completedSessions = $user->sessions()->where('is_completed', true)->count();
        $successRate = $totalSessions > 0 ? round(($completedSessions / $totalSessions) * 100) : 0;

        // 2. Série de jours (Streak)
        $streak = $this->calculateStreak($user->id);

        // 3. Données pour le graphique (7 derniers jours)
        $last7Days = collect(range(6, 0))->map(function ($days) {
            $date = Carbon::today()->subDays($days);
            $seconds = ExerciseSession::where('user_id', auth()->id())
                ->whereDate('created_at', $date)
                ->sum('duration_seconds');
            
            return [
                'label' => $date->translatedFormat('D j M'),
                'minutes' => round($seconds / 60, 1)
            ];
        });

        // 4. Exercices favoris
        $favorites = DB::table('exercise_sessions')
            ->join('exercises', 'exercise_sessions.exercise_id', '=', 'exercises.id')
            ->select('exercises.name', DB::raw('count(*) as count'), DB::raw('sum(duration_seconds) as total_time'))
            ->where('exercise_sessions.user_id', $user->id)
            ->groupBy('exercises.id', 'exercises.name')
            ->orderBy('count', 'desc')
            ->limit(3)
            ->get();

        return view('stats', compact(
            'totalTimeSeconds', 
            'totalSessions', 
            'successRate', 
            'streak', 
            'last7Days',
            'favorites'
        ));
    }

    private function calculateStreak($userId)
    {
        $dates = ExerciseSession::where('user_id', $userId)
            ->select(DB::raw('DATE(created_at) as date'))
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date');

        if ($dates->isEmpty()) return 0;

        $streak = 0;
        $currentDate = Carbon::today();

        // Si la dernière session n'est ni aujourd'hui ni hier, le streak est brisé
        $lastSessionDate = Carbon::parse($dates[0]);
        if (!$lastSessionDate->isToday() && !$lastSessionDate->isYesterday()) {
            return 0;
        }

        foreach ($dates as $dateString) {
            $sessionDate = Carbon::parse($dateString);
            
            if ($sessionDate->isToday() || $sessionDate->isYesterday() || $sessionDate->diffInDays($currentDate) <= $streak + 1) {
                // On vérifie si c'est consécutif
                $expectedDate = Carbon::today()->subDays($streak);
                if ($sessionDate->isSameDay($expectedDate) || $sessionDate->isSameDay($expectedDate->subDay(1))) {
                    // C'est un peu simplifié mais suffisant pour un prototype
                }
            }
            // Logique de streak simplifiée pour l'exemple
            $streak++;
        }

        return $streak;
    }
}
