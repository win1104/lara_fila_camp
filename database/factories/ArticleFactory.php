<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->realText(50);
        return [
            'title' => $title,
            'slug' => Str::slug( $title ),
            'content' => fake()->realText(1000),
            // 'thumbnail' => fake()->imageUrl,
            'media_id' => 2,
            'is_published' => fake()->boolean(),
            'published_at' => fake()->dateTime,
        ];
    }
}
