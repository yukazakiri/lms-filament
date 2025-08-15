<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'employee_id', 'job_title', 'department', 'manager_id', 'hire_date',
        'location', 'address_line_1', 'address_line_2', 'city', 'state_province', 'postal_code', 'country',
        'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship', 'bio',
        'skills', 'interests', 'social_links', 'custom_fields',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'skills' => 'array',
        'interests' => 'array',
        'social_links' => 'array',
        'custom_fields' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
