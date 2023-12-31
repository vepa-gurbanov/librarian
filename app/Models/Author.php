<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Author extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id'];

    public $timestamps = false;

    public $translatable = ['name'];


    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_authors', 'author_id', 'book_id');
    }


    protected static function booted()
    {
        static::saving(function ($obj) {
            $obj->slug = str($obj->name)->slug('_') . '_au:' . $obj->id . '_' . Str::random(8);
        });
    }

}
