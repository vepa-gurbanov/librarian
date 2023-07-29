<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class AttributeValue extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id', 'attribute_id'];

    public $timestamps = false;

    public $translatable = ['name'];


    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }


    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_attribute_values')
            ->orderBy('id', 'desc');
    }


    protected static function booted()
    {
        static::saving(function ($obj) {
            $obj->slug = str($obj->getTranslation('name', 'en'))->slug('_') . '_av:'. $obj->id . '_' . Str::random(8);
        });
    }

}
