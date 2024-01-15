<?php

namespace Tests\Feature\App\Http\Controllers;

use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_make_product_thumbnail(): void
    {
        $method = 'resize';
        $size = '200x200';

        $product = ProductFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        $this->get(route('thumbnail', [
            'dir' => $product->thumbnailDir(),
            'method' => $method,
            'size' => $size,
            'file' => File::basename($product->{$product->thumbnailColumn()}),
        ]))->assertOk();

        Storage::disk('images')->assertExists(
            "products/$method/$size/".File::basename($product->thumbnail)
        );
    }

    public function test_make_brand_thumbnail(): void
    {
        $method = 'resize';
        $size = '200x200';

        $brand = BrandFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        $this->get(route('thumbnail', [
            'dir' => $brand->thumbnailDir(),
            'method' => $method,
            'size' => $size,
            'file' => File::basename($brand->{$brand->thumbnailColumn()}),
        ]))->assertOk();

        Storage::disk('images')->assertExists(
            "products/$method/$size/".File::basename($brand->$brand)
        );
    }
}
