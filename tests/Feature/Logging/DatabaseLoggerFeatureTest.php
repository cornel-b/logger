<?php

namespace Tests\Feature\Logging;

use App\Models\AppLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DatabaseLoggerFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_controller_errors_to_database()
    {
        $response = $this->get('/test/division-by-zero');
        $response->assertStatus(500);

        $this->assertDatabaseHas('app_logs', [
            'verbosity_level' => 'error',
            'route_path' => 'test/division-by-zero',
            'route_method' => 'GET',
        ]);
    }

    public function test_it_logs_different_log_levels()
    {
        $response = $this->get('/test/log-only');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Logs have been created']);

        $this->assertDatabaseHas('app_logs', [
            'verbosity_level' => 'debug',
            'route_path' => 'test/log-only',
        ]);
        $this->assertDatabaseHas('app_logs', [
            'verbosity_level' => 'info',
            'route_path' => 'test/log-only',
        ]);
        $this->assertDatabaseHas('app_logs', [
            'verbosity_level' => 'warning',
            'route_path' => 'test/log-only',
        ]);
        $this->assertDatabaseHas('app_logs', [
            'verbosity_level' => 'error',
            'route_path' => 'test/log-only',
        ]);

        expect(AppLog::count())->toBe(4);
    }

    public function test_it_logs_manually_created_log_entries()
    {
        Log::debug('Manual debug message');
        Log::info('Manual info message', ['context' => 'test']);
        Log::warning('Manual warning message');
        Log::error('Manual error message', ['exception' => new \Exception('Manual exception')]);

        expect(AppLog::count())->toBe(4);
        $this->assertDatabaseHas('app_logs', [
            'verbosity_level' => 'debug',
        ]);
    }
}
