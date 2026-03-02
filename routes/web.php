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

// Route PUBLIQUE (accessible sans compte)
Route::get('/respiration/{id}', [CesiZenController::class, 'respiration'])->name('respiration.show');

// Page publique pour voir les exercices
Route::get('/exercices', [CesiZenController::class, 'publicExercises'])->name('public.exercises');

// Routes protégées (Il faut être connecté)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // NOUVELLES ROUTES : Créer/Modifier son exercice perso
    Route::get('/mon-exercice', [CesiZenController::class, 'editPersonal'])->name('personal.edit');
    Route::post('/mon-exercice', [CesiZenController::class, 'storePersonal'])->name('personal.store');
});

// Groupe Admin : Seul l'utilisateur avec role='admin' peut entrer ici
Route::middleware(['auth', 'admin']) // <--- 'admin' est une string, donc plus d'erreur !
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        // Route cachée pour sauvegarder l'ordre via Glisser-Déposer
        Route::post('exercises/reorder', [AdminExerciseController::class, 'reorder'])->name('exercises.reorder');
        
        // Ta route existante :
        Route::resource('exercises', AdminExerciseController::class);
});
require __DIR__.'/auth.php';