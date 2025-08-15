<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','slug','description','category','resource','action','is_system'
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions')->withPivot(['granted']);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions')
            ->withPivot(['context_type','context_id','granted','assigned_by','assigned_at','expires_at','revoked_at','revoked_by'])
            ->withTimestamps();
    }
}
