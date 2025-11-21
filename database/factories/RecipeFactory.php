<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\recipes>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(),
            'prep_time' => $this->faker->numberBetween(1, 50),
            'cook_time' => $this->faker->numberBetween(1, 50),
            'difficulty' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'image_url' => $this->faker->imageUrl(200, 300, 'recipes', true, 'Recipe Cover'),
        ];
    }
}
