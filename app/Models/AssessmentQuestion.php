<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid','assessment_id','question_type','question_text','question_html','points','sort_order','is_required','time_limit','question_data','media_files'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'question_data' => 'array',
        'media_files' => 'array',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
