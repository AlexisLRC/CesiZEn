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
}
