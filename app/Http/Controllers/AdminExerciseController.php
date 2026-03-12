<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class AdminExerciseController extends Controller
{
    // Affiche la liste des exercices (Back-Office)
    public function index()
    {
        // On ne récupère QUE les exercices globaux (user_id est null)
        $exercises = Exercise::whereNull('user_id')->orderBy('order', 'asc')->get();
        return view('admin.exercises.index', compact('exercises'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('admin.exercises.form');
    }

    // Enregistre un nouvel exercice
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_inhale' => 'required|integer|min:1',
            'duration_hold' => 'required|integer|min:0',
            'duration_exhale' => 'required|integer|min:1',
        ]);

        Exercise::create($data);
        return redirect()->route('admin.exercises.index')->with('success', 'L\'exercice a été créé avec succès.');
    }

    // Affiche le formulaire d'édition
    public function edit(Exercise $exercise)
    {
        return view('admin.exercises.form', compact('exercise'));
    }

    // Met à jour l'exercice
    public function update(Request $request, Exercise $exercise)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_inhale' => 'required|integer|min:1',
            'duration_hold' => 'required|integer|min:0',
            'duration_exhale' => 'required|integer|min:1',
        ]);

        $exercise->update($data);
        return redirect()->route('admin.exercises.index')->with('success', 'L\'exercice a été mis à jour avec succès.');
    }

    // Supprime l'exercice
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('admin.exercises.index')->with('success', 'L\'exercice a été supprimé avec succès.');
    }

    // Sauvegarde le nouvel ordre après un drag & drop
    public function reorder(Request $request)
    {
        $orderArray = $request->input('order'); // Reçoit un tableau d'IDs
        
        foreach ($orderArray as $index => $id) {
            Exercise::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}