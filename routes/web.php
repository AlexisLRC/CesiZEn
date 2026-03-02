<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CesiZenController; // <--- VÉRIFIE QUE CETTE LIGNE EST LÀ
use App\Http\Controllers\AdminExerciseController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/a-propos', function () {
    return view('about');
})->name('about');

// Dashboard (Tableau de bord)
Route::get('/', [CesiZenController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes protégées (Il faut être connecté)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---> AJOUTE CETTE LIGNE QUI MANQUE <---
    Route::get('/respiration/{id}', [CesiZenController::class, 'respiration'])->name('respiration.show');
});

// Groupe Admin : Seul l'utilisateur avec role='admin' peut entrer ici
Route::middleware(['auth', 'admin']) // <--- 'admin' est une string, donc plus d'erreur !
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        Route::resource('exercises', AdminExerciseController::class);
});
require __DIR__.'/auth.php';