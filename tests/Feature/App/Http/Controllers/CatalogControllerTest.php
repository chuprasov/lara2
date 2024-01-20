<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CatalogController;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_price_filtered_response(): void
    {
        BrandFactory::new()
            ->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 900,
            ]);

        $products = ProductFactory::new()
            ->count(10)
            ->create(['price' => 200]);

        $expectedProduct = ProductFactory::new()
            ->count(10)
            ->createOne(['price' => 100000]);

        $request = [
            'filters' => [
                'price' => ['from' => 900, 'to' => 1001],
            ],
        ];

        $this->get(action(CatalogController::class, $request))
            ->assertOk()
            ->assertSee($expectedProduct->title)
            ->assertDontSee($products->random()->first()->title);
    }

    public function test_success_brand_filtered_response(): void
    {
        BrandFactory::new()
            ->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 900,
            ]);

        $products = ProductFactory::new()
            ->count(10)
            ->create();

        $brand = BrandFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        $expectedProduct = ProductFactory::new()
            ->createOne([
                'brand_id' => $brand->id,
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        $request = [
            'filters' => [
                'brand' => [$brand->id => $brand->id],
            ],
        ];

        $this->get(action(CatalogController::class, $request))
            ->assertOk()
            ->assertSee($expectedProduct->title)
            ->assertDontSee($products->random()->first()->title);
    }

    public function sortTest(string $sortKey): void
    {
        $products = ProductFactory::new()
            ->count(3)
            ->create();

        $request = [
            'sort' => $sortKey,
        ];

        $this->get(action(CatalogController::class, $request))
            ->assertOk()
            ->assertSeeInOrder(
                $products->sortBy($sortKey)
                    ->flatMap(fn ($item) => [$item->{$sortKey}])
                    ->toArray()
            );
    }

    public function test_success_title_sorted_response(): void
    {
        $this->sortTest('title');
    }

    public function test_success_price_sorted_response(): void
    {
        $this->sortTest('price');
    }
}
