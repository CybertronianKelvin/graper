<?php

declare(strict_types=1);

namespace CybertronianKelvin\Graper\Commands;

use Illuminate\Console\Command;

class GraperInstallCommand extends Command
{
    protected $signature = 'graper:install';

    protected $description = 'Install Graper package';

    public function handle(): int
    {
        $this->info('Installing Graper...');

        $this->call('filament:install', ['--panels' => true]);

        $this->call('vendor:publish', [
            '--provider' => 'CybertronianKelvin\Graper\GraperServiceProvider',
            '--tag' => 'graper-config',
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'CybertronianKelvin\Graper\GraperServiceProvider',
            '--tag' => 'graper-migrations',
        ]);

        $this->call('migrate');

        $this->info('Graper installed successfully.');

        return self::SUCCESS;
    }
}
