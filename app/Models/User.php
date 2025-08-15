<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'middle_name',
        'display_name',
        'email',
        'username',
        'password',
        'avatar_url',
        'phone',
        'mobile',
        'date_of_birth',
        'gender',
        'timezone',
        'locale',
        'status',
        'last_login_at',
        'last_activity_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'last_activity_at' => 'datetime',
            'password_changed_at' => 'datetime',
        ];
    }

    /**
     * Automatically assign a UUID when creating a new user.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $user): void {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // Relationships

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function authenticationMethods()
    {
        return $this->hasMany(UserAuthenticationMethod::class);
    }

    public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }

    public function organizationMemberships()
    {
        return $this->hasMany(UserOrganizationMembership::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'user_organization_memberships')
            ->withPivot(['role', 'title', 'is_primary', 'joined_at', 'left_at', 'status'])
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withPivot(['organization_id', 'context_type', 'context_id', 'assigned_by', 'assigned_at', 'expires_at', 'revoked_at', 'revoked_by', 'revoke_reason'])
            ->withTimestamps();
    }

    public function directPermissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')
            ->withPivot(['context_type', 'context_id', 'granted', 'assigned_by', 'assigned_at', 'expires_at', 'revoked_at', 'revoked_by'])
            ->withTimestamps();
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function learningProgress()
    {
        return $this->hasMany(LearningProgress::class);
    }

    public function learningSessions()
    {
        return $this->hasMany(LearningSession::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(LearningBookmark::class);
    }

    public function notes()
    {
        return $this->hasMany(LearningNote::class);
    }

    public function completions()
    {
        return $this->hasMany(CourseCompletion::class);
    }

    public function coursesCreated()
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    public function coursesUpdated()
    {
        return $this->hasMany(Course::class, 'updated_by');
    }

    // Filament User Interface Methods

    /**
     * Determine if the user can access the given Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true; // You can add more specific logic here if needed
    }

    /**
     * Get the tenants (organizations) that the user belongs to.
     */
    public function getTenants(Panel $panel): Collection
    {
        return $this->organizations;
    }

    /**
     * Determine if the user can access the given tenant (organization).
     */
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->organizations()->whereKey($tenant)->exists();
    }
}
