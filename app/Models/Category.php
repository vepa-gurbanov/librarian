<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations, Searchable;

    protected $guarded = ['id', 'parent_id'];

    public $timestamps = false;

    public $translatable = ['name'];

    protected $touches = ['books'];


    protected static function booted()
    {
        static::saving(function ($obj) {
            $obj->slug = str($obj->getTranslation('name', 'en'))->slug('_') . '_c:' . $obj->id . '_' . Str::random(8);
        });
    }


    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_categories', 'category_id', 'book_id');
    }


    public function parent(): BelongsTo // whereNull('parent_id');
    {
        return $this->belongsTo(self::class, 'parent_id');
    }


    public function child(): HasMany // whereNotNull('parent_id')
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('name');
    }


    public function image(): string
    {
        return $this->image
            ? Storage::url('public/categories/' . $this->id . '/' . $this->image)
            : asset('assets/img/category.png');
    }
}
