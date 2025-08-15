<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id','question_id','answer_data','score','is_correct','feedback'
    ];

    protected $casts = [
        'answer_data' => 'array',
        'score' => 'decimal:2',
        'is_correct' => 'boolean',
    ];

    public function attempt()
    {
        return $this->belongsTo(AssessmentAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(AssessmentQuestion::class, 'question_id');
    }
}
