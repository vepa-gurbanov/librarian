<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PhpParser\Comment\Doc;

class Reader extends Authenticatable
{
    use HasFactory;

    protected $guarded = ['id', 'document_id'];


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
}
