<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasUuid;

class Assessment extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid','course_id','activity_id','title','description','instructions','assessment_type','question_count','max_score','passing_score','weight','time_limit','max_attempts','attempt_delay','randomize_questions','randomize_answers','show_results','show_correct_answers','allow_review','require_lockdown_browser','require_webcam','auto_grade','is_practice','is_required','available_from','available_until','due_date','late_submission_allowed','late_penalty_percentage','settings','created_by','updated_by'
    ];

    protected $casts = [
        'max_score' => 'decimal:2',
        'passing_score' => 'decimal:2',
        'weight' => 'decimal:2',
        'randomize_questions' => 'boolean',
        'randomize_answers' => 'boolean',
        'show_correct_answers' => 'boolean',
        'allow_review' => 'boolean',
        'require_lockdown_browser' => 'boolean',
        'require_webcam' => 'boolean',
        'auto_grade' => 'boolean',
        'is_practice' => 'boolean',
        'is_required' => 'boolean',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
        'due_date' => 'datetime',
        'late_submission_allowed' => 'boolean',
        'late_penalty_percentage' => 'decimal:2',
        'settings' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function activity()
    {
        return $this->belongsTo(CourseActivity::class);
    }
}
