<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid','user_id','course_id','course_version_id','enrollment_type','status','progress_percentage','completion_percentage','grade','grade_letter','points_earned','points_possible','enrolled_at','started_at','last_accessed_at','completed_at','expired_at','withdrawn_at','withdrawal_reason','enrolled_by','completion_criteria_met','custom_fields','notes'
    ];

    protected $casts = [
        'progress_percentage' => 'decimal:2',
        'completion_percentage' => 'decimal:2',
        'grade' => 'decimal:2',
        'enrolled_at' => 'datetime',
        'started_at' => 'datetime',
        'last_accessed_at' => 'datetime',
        'completed_at' => 'datetime',
        'expired_at' => 'datetime',
        'withdrawn_at' => 'datetime',
        'completion_criteria_met' => 'array',
        'custom_fields' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function version()
    {
        return $this->belongsTo(CourseVersion::class, 'course_version_id');
    }

    public function enroller()
    {
        return $this->belongsTo(User::class, 'enrolled_by');
    }
}
