<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'shop:install';

    protected $description = 'App install';

    public function handle()
    {
        $this->call('storage:link');
        $this->call('migrate');
        // $this->call('route:list');

        return self::SUCCESS;
    }
}
