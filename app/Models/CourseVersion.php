<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id','version_number','title','description','content_hash','is_current','is_published','change_log','created_by','published_by','published_at'
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }
}
