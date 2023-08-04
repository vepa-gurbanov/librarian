<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range('a', 'z') as $index => $alphabet) {
            $shelf = new Shelf();
            $shelf->name = $alphabet;
            $shelf->sort_order = $index + 1;
            $shelf->save();

            Book::query()
                ->where('slug', 'like',$alphabet . '%')
                ->update(['shelf_id' => $shelf->id]);
        }
    }
}
