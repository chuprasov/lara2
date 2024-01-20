<?php

namespace Database\Factories;

use Domain\Product\Models\Option;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionFactory extends Factory
{
    protected $model = Option::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->word()),
        ];
    }
}
