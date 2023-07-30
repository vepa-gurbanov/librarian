<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $guarded = [
        'id',
        'registration_id',
    ];


    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }


    public function readerBanks(): HasMany
    {
        return $this->hasMany(ReaderBank::class);
    }

}
