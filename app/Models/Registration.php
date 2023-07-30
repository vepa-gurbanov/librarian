<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    protected $guarded = [
        'user_id',
        'reader_id',
        'book_id',
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'took_at',
        'returned_at',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function reader(): BelongsTo
    {
        return $this->belongsTo(Reader::class);
    }


    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
