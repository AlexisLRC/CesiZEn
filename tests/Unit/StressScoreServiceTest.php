<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
// use App\Services\StressScoreService; // À décommenter quand le service existera

class StressScoreServiceTest extends TestCase
{
    // Remplissage du premier TODO demandé par le TP :
    public function test_score_zero_pour_aucun_evenement(): void 
    {
        // 1. Arrange (On prépare les données)
        $events = []; 
        $service = new \stdClass(); // Remplace par 'new StressScoreService()' plus tard
        
        // 2. Act (On exécute la fonction)
        // $result = $service->calculateScore($events);
        $result = 0; // Simulation du résultat en attendant d'avoir la vraie classe
        
        // 3. Assert (On vérifie que le résultat est correct)
        $this->assertEquals(0, $result);
    }
}