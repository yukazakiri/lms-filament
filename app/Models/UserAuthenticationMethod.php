<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAuthenticationMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'provider', 'provider_id', 'provider_email', 'provider_data', 'is_primary', 'verified_at',
    ];

    protected $casts = [
        'provider_data' => 'array',
        'is_primary' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
