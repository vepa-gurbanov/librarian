<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Publisher extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;


    public function books()
    {
        $this->belongsToMany(Book::class, 'book_publishers')
            ->orderByPivot('sort_order');
    }


    protected static function booted()
    {
        static::saving(function ($obj) {
            $obj->slug = str($obj->name)->slug('_') . '_pub:' . $obj->id . '_' . Str::random(8);
        });
    }

}
