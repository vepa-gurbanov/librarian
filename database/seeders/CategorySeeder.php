<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objs = [
            'Fantasy',
            'Sci-Fi',
            'Mystery',
            'Thriller',
            'Romance',
            'Westerns',
            'Dystopian',
            'Contemporary',
        ];

        foreach ($objs as $obj)
        {
            $c = new Category();
            $c->setTranslation('name', 'en', $obj);
            $c->slug = str($obj)->slug('_');
            $c->save();
        }
    }
}
