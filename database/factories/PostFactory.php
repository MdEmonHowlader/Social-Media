<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
 use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'image' => fake()->imageUrl(),
            'title'=> $title,
            'slug' => str($title)->slug(),
            'content' => fake()->paragraph(5),
            'category_id' => Category::inRandomOrder()->first()->id,
            'user_id' => \App\Models\User::factory()->create()->id,
            'published_at' => fake()->optional()->dateTimeBetween('-1 year', 'now') ? fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s') : null,
        ];
    }
}
