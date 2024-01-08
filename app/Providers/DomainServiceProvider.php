<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Auth\Providers\AuthServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            AuthServiceProvider::class
        );
    }
}
