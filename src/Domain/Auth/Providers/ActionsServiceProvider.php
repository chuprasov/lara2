<?php

namespace Domain\Auth\Providers;

// use Illuminate\Support\Facades\Gate;

use Domain\Auth\Actions\RegisterUserAction;
use Domain\Auth\Contracts\RegisterUserContract;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterUserContract::class => RegisterUserAction::class,
    ];

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    public function boot(): void
    {

    }
}
