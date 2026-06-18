<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthMetricsTest extends TestCase
{
    public function test_api_health_retourne_statut_ok(): void
    {
        // Act : On appelle la route
        $response = $this->getJson('/api/health');

        // Assert : On vérifie que tout va bien (code 200) et la structure
        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'version', 'environment', 'timestamp', 'php', 'laravel'])
                 ->assertJson(['status' => 'ok']);
    }

    public function test_api_metrics_retourne_les_metriques(): void
    {
        $response = $this->getJson('/api/metrics');

        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'memory_mb', 'uptime']);
    }
}