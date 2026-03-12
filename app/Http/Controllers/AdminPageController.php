<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::with('author');

        // Filtre par Titre
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filtre par Statut
        if ($request->filled('status')) {
            $status = $request->status === 'published';
            $query->where('is_published', $status);
        }

        // Filtre par Auteur
        if ($request->filled('author')) {
            $query->where('user_id', $request->author);
        }

        // Tri (par défaut par date de création décroissante)
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        
        // Sécurité sur les colonnes de tri
        $allowedSorts = ['title', 'created_at', 'is_published'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        $pages = $query->get();
        $authors = User::whereHas('pages')->get(); // Pour le select des auteurs

        return view('admin.pages.index', compact('pages', 'authors'));
    }

    public function create()
    {
        return view('admin.pages.form', ['page' => new Page()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        $data['is_published'] = $request->has('is_published');
        $data['user_id'] = auth()->id();

        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'Votre article a été créé avec succès.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Mise à jour simplifiée du slug pour garder l'unicité
        $data['slug'] = Str::slug($data['title']) . '-' . $page->id;
        $data['is_published'] = $request->has('is_published');

        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success', 'Votre article a été mis à jour avec succès.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'L\'article a été supprimé avec succès.');
    }
}
