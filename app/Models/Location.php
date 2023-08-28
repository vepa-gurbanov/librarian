<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
    use HasFactory, HasTranslations;

    public $timestamps = false;

    public $translatable = ['name'];


    public function parent() // whereNull('parent_id');
    {
        return $this->belongsTo(self::class, 'parent_id');
    }


    public function child() // whereNotNull('parent_id')
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}
