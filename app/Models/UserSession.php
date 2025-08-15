<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'user_id', 'ip_address', 'user_agent', 'device_type', 'browser', 'platform', 'location', 'is_mobile', 'last_activity',
    ];

    protected $casts = [
        'is_mobile' => 'boolean',
        'last_activity' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
