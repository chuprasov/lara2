<?php

namespace Tests\Feature\App\Jobs;

use App\Jobs\ProductJsonPropertiesJob;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProductJsonPropertiesJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_created_json_properties(): void
    {
        Queue::fake([ProductJsonPropertiesJob::class]);

        $properties = PropertyFactory::new()
            ->count(10)
            ->create();

        $product = ProductFactory::new()
            ->hasAttached($properties, function () {
                return ['value' => ucfirst(fake()->word())];
            })
            ->create();

        $this->assertEmpty($product->json_properties);

        Queue::assertPushed(ProductJsonPropertiesJob::class);

        Queue::swap($this->realQueue);

        ProductJsonPropertiesJob::dispatchSync($product);

        $product->refresh();

        $this->assertNotEmpty($product->json_properties);
    }
}
