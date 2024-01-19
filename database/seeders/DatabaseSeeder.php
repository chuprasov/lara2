<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\PropertyFactory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
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
                        return ['value' => ucfirst(fake()->word())];
                    })
                    ->hasAttached($optionsValues)
            )
            ->create();
    }
}
