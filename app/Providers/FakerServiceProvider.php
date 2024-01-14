<?php

namespace App\Providers;

use App\Faker\FileProvider;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider(new FileProvider($faker));

            return $faker;
        });
    }
}
