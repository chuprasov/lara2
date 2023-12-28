<?php

namespace App\Faker;

use Faker\Provider\Base;
use Faker\Factory;

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
