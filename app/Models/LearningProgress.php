<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','course_id','module_id','lesson_id','activity_id','content_type','content_id','status','progress_percentage','time_spent','attempts_count','max_attempts','score','max_score','passed','first_accessed_at','last_accessed_at','completed_at','data'
    ];

    protected $casts = [
        'progress_percentage' => 'decimal:2',
        'score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'passed' => 'boolean',
        'first_accessed_at' => 'datetime',
        'last_accessed_at' => 'datetime',
        'completed_at' => 'datetime',
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    public function activity()
    {
        return $this->belongsTo(CourseActivity::class, 'activity_id');
    }
}
