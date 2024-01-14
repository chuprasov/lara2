<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_make_thumbnail(): void
    {
        $product = ProductFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1
            ]);

        $this->get(route('thumbnail', [
            'dir' => $product->thumbnailDir(),
            'method' => 'resize',
            'size' => '200x200',
            'file' => File::basename($product->{$product->thumbnailColumn()})
        ]))->assertOk();
    }
}
