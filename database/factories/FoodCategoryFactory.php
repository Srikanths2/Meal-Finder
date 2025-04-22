<?php

namespace Database\Factories;

use App\Models\FoodCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodCategoryFactory extends Factory
{
    protected $model = FoodCategory::class;

    public function definition()
    {
        return [
            'categories' => $this->faker->word,
            'name' => $this->faker->word,
            'image' => $this->faker->imageUrl(),
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'active' => $this->faker->boolean,
        ];
    }
}
