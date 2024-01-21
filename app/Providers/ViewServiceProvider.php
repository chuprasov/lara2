<?php

namespace App\Providers;

use App\View\Composers\NavigationComposer;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Vite::macro('image', fn ($asset) => $this->asset("resources/images/$asset"));

        View::composer('*', NavigationComposer::class);
    }
}
