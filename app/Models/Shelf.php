<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Shelf extends Model
{
    use HasFactory;

    public $timestamps = false;


    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }


    public function reader(): BelongsTo
    {
        return $this->belongsTo(Reader::class);
    }


    public function image(): string
    {
        return $this['image']
            ? Storage::url('shelves/' . $this->id . '/' . $this->image)
            : asset('img/shelf.png');
    }
}
