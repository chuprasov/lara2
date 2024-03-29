<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'shop:refresh';

    protected $description = 'Shop app refresh';

    public function handle()
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }

        Storage::deleteDirectory('images/products');

        if (! Storage::exists('images/products')) {
            Storage::makeDirectory('images/products');
        }

        Storage::deleteDirectory('images/brands');

        if (! Storage::exists('images/brands')) {
            Storage::makeDirectory('images/brands');
        }

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);

        $this->call('cache:clear');

        $this->call('queue:work');

        return self::SUCCESS;
    }
}
