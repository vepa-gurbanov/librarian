<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Option extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['*'];

    public const formats = [
        'electron' => ['pdf', 'epub'],
        'audiobook' => ['mp3']
    ];


    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
