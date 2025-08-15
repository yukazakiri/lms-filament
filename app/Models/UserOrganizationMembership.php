<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrganizationMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','organization_id','role','title','is_primary','joined_at','left_at','status'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
