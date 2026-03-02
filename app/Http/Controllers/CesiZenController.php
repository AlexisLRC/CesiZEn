<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Page;
use Illuminate\Http\Request;

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
    public function respiration($id) {
        $exercise = Exercise::findOrFail($id);
        return view('respiration', compact('exercise'));
    }
    
    // Affiche la liste des exercices pour les visiteurs (ou redirige si connecté)
    public function publicExercises()
    {
        // 1. Si l'utilisateur est connecté, on le redirige vers son Espace
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        // 2. Sinon, on récupère les exercices globaux et on affiche la vue publique
        $exercises = Exercise::whereNull('user_id')->orderBy('order', 'asc')->get();
        return view('public-exercises', compact('exercises'));
    }

    // Affiche les pages informatives (Stress, Détente, etc.)
    public function informations()
    {
        // On récupère toutes les pages depuis la base de données
        // (Assure-toi que ton modèle s'appelle bien "Page")
        $pages = \App\Models\Page::all(); 
        
        return view('informations', compact('pages'));
    }

    // Affiche le formulaire pour l'exercice perso
    public function editPersonal()
    {
        // Cherche si l'utilisateur a déjà un exercice
        $exercise = \App\Models\Exercise::where('user_id', auth()->id())->first();
        return view('personal-exercise', compact('exercise'));
    }

    // Sauvegarde l'exercice perso
    public function storePersonal(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'duration_inhale' => 'required|integer|min:1',
            'duration_hold' => 'required|integer|min:0',
            'duration_exhale' => 'required|integer|min:1',
        ]);

        // updateOrCreate met à jour s'il existe déjà, sinon il le crée (garantit 1 seul exercice max)
        \App\Models\Exercise::updateOrCreate(
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
}
