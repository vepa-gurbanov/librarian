<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReaderBank extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $guarded = [
        'id',
        'reader_id',
        'bank_id',
    ];


    public function reader(): BelongsTo
    {
        return $this->belongsTo(Reader::class);
    }


    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
