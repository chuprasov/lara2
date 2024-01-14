<?php

namespace App\Faker;

use Faker\Factory;
use Faker\Provider\Base;

class FileProvider extends Base
{
    public function loadFile(string $fileFrom, string $fileTo): string
    {
        $faker = Factory::create();

        return $faker->file(
            base_path($fileFrom),
            storage_path($fileTo),
            false
        );
    }
}
