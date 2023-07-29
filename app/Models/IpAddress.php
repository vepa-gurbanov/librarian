<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IpAddress extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const UPDATED_AT = null;


    public function authAttempts(): HasMany
    {
        return $this->hasMany(AuthAttempt::class)
            ->orderBy('id');
    }
}
