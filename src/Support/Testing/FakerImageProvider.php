<?php

declare(strict_types=1);

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
    public function fixturesImages(string $fixturesDir, string $storageDir): string
    {
        $disk = Storage::disk('images');

        if (! $disk->exists($storageDir)) {
            $disk->makeDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/Images/$fixturesDir"),
            $disk->path($storageDir),
            false
        );

        return $file;
    }
}
