<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasUuid;

class LearningNote extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid','user_id','course_id','module_id','lesson_id','activity_id','content_type','content_id','title','content','content_html','is_private','is_shared','tags','attachments'
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'is_shared' => 'boolean',
        'tags' => 'array',
        'attachments' => 'array',
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
