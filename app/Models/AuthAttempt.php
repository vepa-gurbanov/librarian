<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthAttempt extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'ip_address_id', 'user_agent_id'];

    const UPDATED_AT = null;


    public function ipAddress(): BelongsTo
    {
        return $this->belongsTo(IpAddress::class);
    }


    public function userAgent(): BelongsTo
    {
        return $this->belongsTo(UserAgent::class);
    }

}
