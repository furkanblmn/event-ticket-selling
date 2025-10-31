<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/**
 * Application Setup Command
 *
 * Sets up the application by generating key, running migrations and seeders
 */
class AppSet extends Command
{
    protected $signature = 'app:set {--skip-queue : Skip starting queue worker}';
    protected $description = 'Key generation + Migration + seeding + Queue worker';

    public function handle(): void
    {
        $this->info('🚀 Project setup started.');
        $this->newLine();

        $steps = [
            'Key generation',
            'Running fresh migration and seed',
            'Clearing caches',
        ];

        $this->withProgressBar($steps, function ($step) {
            match ($step) {
                'Key generation' => Artisan::call('key:generate'),
                'Running fresh migration and seed' => Artisan::call('migrate:fresh --seed'),
                'Clearing caches' => $this->clearCaches(),
            };
        });

        $this->newLine(2);
        $this->info('✅ Project setup completed.');
        $this->newLine();

        if (!$this->option('skip-queue')) {
            $this->startQueueWorker();
        }
    }

    private function clearCaches(): void
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
    }

    private function startQueueWorker(): void
    {
        $this->info('📬 Queue worker setup:');
        $this->newLine();

        if ($this->isWindows()) {
            $this->warn('⚠️  Windows detected. Please start queue worker manually:');
            $this->line('   php artisan queue:work');
        } else {
            if ($this->confirm('Do you want to start the queue worker in background?', true)) {
                $command = 'php artisan queue:work > /dev/null 2>&1 &';
                exec($command);
                $this->info('✅ Queue worker started in background.');
                $this->line('   To monitor: tail -f storage/logs/laravel.log');
                $this->line('   To stop: php artisan queue:restart');
            } else {
                $this->warn('⚠️  Queue worker not started. Start it manually:');
                $this->line('   php artisan queue:work');
            }
        }

        $this->newLine();
        $this->info('💡 Tip: For production, use Supervisor to manage queue workers.');
    }

    private function isWindows(): bool
    {
        return PHP_OS_FAMILY === 'Windows';
    }
}
