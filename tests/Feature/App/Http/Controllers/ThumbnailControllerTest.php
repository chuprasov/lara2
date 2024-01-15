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

    private function makeThumbnailTesting(string $factory, string $modelDirlName)
    {
        $method = 'resize';
        $size = '200x200';

        $object = $factory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        $this->get(route('thumbnail', [
            'dir' => $object->thumbnailDir(),
            'method' => $method,
            'size' => $size,
            'file' => File::basename($object->{$object->thumbnailColumn()}),
        ]))->assertOk();

        Storage::disk('images')->assertExists(
            "$modelDirlName/$method/$size/".File::basename($object->thumbnail)
        );
    }

    public function test_make_product_thumbnail(): void
    {
        $this->makeThumbnailTesting(ProductFactory::class, 'products');
    }

    public function test_make_brand_thumbnail(): void
    {
        $this->makeThumbnailTesting(BrandFactory::class, 'brands');
    }
}
