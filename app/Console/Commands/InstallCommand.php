<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'app:install';

    protected $description = 'App install';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('storage:link');
        $this->call('migrate');
        $this->call('route:list');

        return self::SUCCESS;
    }
}
