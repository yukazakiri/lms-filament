<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid','user_id','course_id','enrollment_id','completion_type','completion_date','final_grade','final_grade_letter','total_points_earned','total_points_possible','completion_time','criteria_met','certificate_issued','certificate_id','certificate_url','certificate_issued_at','completed_by','notes','metadata'
    ];

    protected $casts = [
        'completion_date' => 'datetime',
        'final_grade' => 'decimal:2',
        'criteria_met' => 'array',
        'certificate_issued' => 'boolean',
        'certificate_issued_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(CourseEnrollment::class, 'enrollment_id');
    }
}
