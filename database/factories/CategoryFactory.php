<?php

namespace Database\Factories;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)).'-cat',
            'on_home_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 900),
        ];
    }
}
