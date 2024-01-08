<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'app:refresh';

    protected $description = 'App refresh';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }

        Storage::deleteDirectory('images/products');

        if(!Storage::exists('images/products')) {
            Storage::makeDirectory('images/products');
        }

        Storage::deleteDirectory('images/brands');

        if(!Storage::exists('images/brands')) {
            Storage::makeDirectory('images/brands');
        }

        /* $files = Storage::allFiles('images/products');
        dd($files);
        Storage::delete($files); */

        $this->call('migrate:fresh', [
            '--seed' => true
        ]);

        return self::SUCCESS;
    }
}
