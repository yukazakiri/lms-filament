<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model implements HasName, HasAvatar
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid','parent_id','name','slug','description','type','logo_url','website','phone','email','address_line_1','address_line_2','city','state_province','postal_code','country','timezone','locale','settings','status'
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function parent()
    {
        return $this->belongsTo(Organization::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Organization::class, 'parent_id');
    }

    public function memberships()
    {
        return $this->hasMany(UserOrganizationMembership::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_organization_memberships')
            ->withPivot(['role', 'title', 'is_primary', 'joined_at', 'left_at', 'status'])
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function courseCategories()
    {
        return $this->hasMany(CourseCategory::class);
    }

    // Filament Interface Methods

    /**
     * Get the name to display in Filament.
     */
    public function getFilamentName(): string
    {
        return $this->name;
    }

    /**
     * Get the avatar URL for Filament.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->logo_url;
    }
}
