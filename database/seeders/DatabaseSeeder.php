<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\PropertyFactory;
use Database\Factories\UserFactory;
use Domain\Catalog\Models\Brand;
use Domain\Product\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        UserFactory::new()
            ->hasAttached(
                Role::factory()
                    ->count(1)
                    ->createOne([
                        'title' => 'admin',
                    ]),
            )
            ->createOne([
                'id' => '1',
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '12345678',
            ]);

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
                        return ['value' => ucfirst(fake()->word()).'-prop-val'];
                    })
                    ->hasAttached($optionsValues)
            )
            ->create();
    }
}
