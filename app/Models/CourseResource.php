<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasUuid;

class CourseResource extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid','course_id','module_id','lesson_id','title','description','resource_type','file_path','file_url','file_size','mime_type','is_downloadable','is_required','access_level','sort_order','metadata','created_by'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_downloadable' => 'boolean',
        'is_required' => 'boolean',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
