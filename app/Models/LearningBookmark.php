<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningBookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','course_id','module_id','lesson_id','activity_id','content_type','content_id','title','notes','tags','is_private'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_private' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
