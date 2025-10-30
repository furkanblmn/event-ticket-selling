<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class AppSet extends Command
{
    protected $signature = 'app:set';
    protected $description = 'Key generation + Migration + seeding';

    public function handle(): void
    {
        $this->info('🚀 Project setup started.');
        $this->newLine();

        $steps = [
            'Key generation',
            'Running fresh migration and seed',
        ];

        $this->withProgressBar($steps, function ($step) {
            match ($step) {
                'Key generation' => Artisan::call('key:generate'),
                'Running fresh migration and seed' => Artisan::call('migrate:fresh --seed'),
            };
        });

        $this->newLine(2);
        $this->info('✅ Project setup completed.');
    }
}
