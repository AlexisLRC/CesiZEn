<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Compte Administrateur (Ministère)
        \App\Models\User::factory()->create([
            'name' => 'Admin Ministère',
            'email' => 'admin@sante.gouv.fr',
            'password' => bcrypt('password'), // Mdp sécurisé
            'role' => 'admin',
        ]);

        // 2. Exercices de respiration (Selon ton Cahier des charges)
        \App\Models\Exercise::create([
            'name' => 'Équilibre (5-5)',
            'description' => 'Idéal pour réguler le rythme cardiaque.',
            'duration_inhale' => 5, 'duration_hold' => 0, 'duration_exhale' => 5
        ]);
        \App\Models\Exercise::create([
            'name' => 'Déconnexion (4-7-8)',
            'description' => 'Pour favoriser le sommeil.',
            'duration_inhale' => 4, 'duration_hold' => 7, 'duration_exhale' => 8
        ]);

        \App\Models\Page::create([
            'title' => 'Comprendre le stress',
            'slug' => 'comprendre-le-stress',
            'content' => 'Le stress est une réaction physiologique naturelle...'
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
