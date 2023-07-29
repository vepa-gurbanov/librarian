<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Reader;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    public function configure(): BookFactory
    {
        return $this->afterMaking(function (Book $book) {
            //
        })->afterCreating(function (Book $book) {
            $book->categories()->sync(Category::inRandomOrder()->take(rand(1,3))->pluck('id')->toArray());
            $book->authors()->sync(Author::inRandomOrder()->take(rand(1,3))->pluck('id')->toArray());
            $book->publishers()->sync(Publisher::inRandomOrder()->take(rand(1,2))->pluck('id')->toArray());

            $description = [];
            $values = [];

            $attrs = Attribute::with(['values'])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

            foreach ($attrs as $attr) {
                $value = $attr->values->random();
                $description[] = $attr->name . ': ' . $value->name;
                $values[$value->id] = ['sort_order' => $attr->sort_order];
            }

            $fullName = $book->name . ', ' . implode(", ", $book->authors()->pluck('name')->toArray()) . ', ' . date_format($book->written_at, 'Y');
            $book->setTranslation('full_name', 'en', $fullName);
            $book->setTranslation('description', 'en', implode(", ", $description) . '.');
            $book->update();

            $book->attributeValues()->sync($values);
        });
    }

    public function definition(): array
    {
        $reader = $this->faker->boolean('20')
            ? Reader::where('status', 1)->inRandomorder()->first()->id
            : null;
        $readerId = $reader ?: null;
        $name = $this->faker->name() . ' ' . $this->faker->streetSuffix();
        $createdAt = now()->subDays(rand(1,31));
        $rand = rand(1, 25);
        $wRand = $rand > 1 ? rand(1, $rand) : 1;
        return [
            'reader_id' => $readerId,
            'name' => $name,
            'body' => $this->faker->sentences(mt_rand(2,6), true),
            'barcode' => Str::random('8'),
            'book_code' => rand(1000, 9999),
            'page' => rand(50, 1000),
            'price' => rand(10, 100),
            'value' => rand(99, 999),
            'liked' => rand(0, 200),
            'viewed' => rand(200, 1000),
            'created_at' => $createdAt,
            'published_at' => $createdAt->subYears($rand),
            'written_at' => $createdAt->subYears($wRand),
        ];
    }
}
