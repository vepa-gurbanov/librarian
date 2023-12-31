<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Reader extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'password',
        'status',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'password' => 'hashed',
    ];


    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }


    public function shelf(): HasOne
    {
        return $this->hasOne(Shelf::class);
    }


    public function ratedBooks(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_ratings');
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
