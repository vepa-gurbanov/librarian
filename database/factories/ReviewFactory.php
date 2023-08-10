<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Reader;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::query()->inRandomOrder()->first()->id,
            'reader_id' => Reader::query()->inRandomOrder()->first()->id,
            'review' => $this->faker->realTextBetween(50, 150),
            'created_at' => now()->subHours(mt_rand(1, 100)),
        ];
    }
}
