<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = ['book_id', 'reader_id', 'review'];


    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }


    public function reader(): BelongsTo
    {
        return $this->belongsTo(Reader::class);
    }
}
