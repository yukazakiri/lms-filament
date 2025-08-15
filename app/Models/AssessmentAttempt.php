<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid','assessment_id','user_id','enrollment_id','attempt_number','started_at','submitted_at','graded_at','duration','score','max_score','passed','status','answers','feedback','metadata'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'passed' => 'boolean',
        'answers' => 'array',
        'feedback' => 'array',
        'metadata' => 'array',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
