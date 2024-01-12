<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Brand::factory(20)->create();

        Category::factory(10)
            ->has(Product::factory(rand(3, 10)))
            ->create();
    }
}
