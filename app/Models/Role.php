<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasUuid;

class Role extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid','organization_id','name','slug','description','type','level','parent_role_id','is_default','is_system','permissions','settings'
    ];

    protected $casts = [
        'permissions' => 'array',
        'settings' => 'array',
        'is_default' => 'boolean',
        'is_system' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function parent()
    {
        return $this->belongsTo(Role::class, 'parent_role_id');
    }

    public function children()
    {
        return $this->hasMany(Role::class, 'parent_role_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles')
            ->withPivot(['organization_id','context_type','context_id','assigned_by','assigned_at','expires_at','revoked_at','revoked_by','revoke_reason'])
            ->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withPivot(['granted'])
            ->withTimestamps();
    }
}
