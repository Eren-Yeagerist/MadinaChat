<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatSession>
 */
class ChatSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->sentence(3);
        $slug = str_slug($title, '-');
        return [
            'user_id' => fake()->numberBetween(1, 20),
            'title' => $title,
            'slug' => $slug,
            'status' => fake()->randomElement([0, 1, 2]),
            'status_rating' => fake()->randomElement([0, 1]),
        ];
    }
}
