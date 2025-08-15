<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasUuid;

class CourseActivity extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid','lesson_id','module_id','course_id','title','description','instructions','activity_type','activity_data','max_attempts','time_limit','passing_score','weight','is_graded','is_required','is_active','unlock_conditions','completion_criteria','feedback_settings','sort_order','due_date','available_from','available_until'
    ];

    protected $casts = [
        'activity_data' => 'array',
        'unlock_conditions' => 'array',
        'completion_criteria' => 'array',
        'feedback_settings' => 'array',
        'is_graded' => 'boolean',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'due_date' => 'datetime',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function lesson()
    {
        return $this->belongsTo(CourseLesson::class, 'lesson_id');
    }
}
