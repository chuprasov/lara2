<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\PropertyFactory;
use Domain\Catalog\Models\Brand;
use Domain\Product\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \Domain\Product\Models\User::factory(10)->create();

        // \Domain\Product\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Brand::factory(20)->create();

        BrandFactory::new()
            ->count(20)
            ->create();

        $properties = PropertyFactory::new()
            ->count(10)
            ->create();

        OptionFactory::new()
            ->count(2)
            ->create();

        $optionsValues = OptionValueFactory::new()
            ->count(10)
            ->create();

        CategoryFactory::new()->count(10)
            ->has(
                Product::factory(rand(3, 10))
                    ->hasAttached($properties, function () {
                        return ['value' => ucfirst(fake()->word()).'- prop-val'];
                    })
                    ->hasAttached($optionsValues)
            )
            ->create();
    }
}
