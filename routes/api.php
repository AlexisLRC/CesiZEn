// routes/api.php
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'version' => config('app.version', '1.0.0'),
        'environment' => app()->environment(),
        'timestamp' => now()->toIso8601String(),
        'php' => PHP_VERSION,
        'laravel' => app()->version(),
    ]);
});

Route::get('/metrics', function () {
    return response()->json([
        'status' => 'ok',
        'version' => config('app.version', '1.0.0'),
        'environment' => app()->environment(),
        'php' => PHP_VERSION,
        'memory_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
        'memory_peak_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
        'uptime' => time() - filemtime(base_path('.env')),
        'timestamp' => now()->toIso8601String(),
    ]);
});