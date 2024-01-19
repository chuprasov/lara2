<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\HomeController;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_success(): void
    {
        /* CategoryFactory::new()
            ->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 900,
            ]);

        BrandFactory::new()
            ->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 900,
            ]);

        ProductFactory::new()
            ->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 900,
            ]); */

        $category = CategoryFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        $brand = BrandFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        $product = ProductFactory::new()
            ->createOne([
                'brand_id' => $brand->id,
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        $this->get(action(HomeController::class))
            ->assertOk()
            ->assertViewHas('products.0', $product)
            ->assertViewHas('categories.0', $category)
            ->assertViewHas('brands.0', $brand);
    }
}
