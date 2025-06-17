<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_code' => fake()->unique()->text(10),
            'book_title' => fake()->text(20),
            'author' => fake()->name(),
            'category' => rand(1, 6),
            'publisher' => fake()->text(20),
            'stock' => rand(1, 10),
            'book_desc' => fake()->text(120),
        ];
    }
}
