<?php

namespace Database\Factories;

use Domain\Product\Models\Option;
use Domain\Product\Models\OptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionValueFactory extends Factory
{
    protected $model = OptionValue::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->word()).'- opt - val',
            'option_id' => Option::query()->inRandomOrder()->value('id'),
        ];
    }
}
