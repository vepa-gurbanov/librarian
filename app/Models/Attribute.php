<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id'];

    public $timestamps = false;

    public $translatable = ['name'];


    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }


    protected static function booted()
    {
        static::saving(function ($obj) {
            $obj->slug = str($obj->getTranslation('name', 'en'))->slug('_') . '_a:' . $obj->id . '_' . Str::random(8);
        });
    }
}
