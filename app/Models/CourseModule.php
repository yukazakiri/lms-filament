<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasUuid;

class CourseModule extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid','course_id','course_version_id','parent_module_id','title','description','objectives','estimated_duration','sort_order','is_required','is_active','unlock_conditions','completion_criteria','metadata'
    ];

    protected $casts = [
        'unlock_conditions' => 'array',
        'completion_criteria' => 'array',
        'metadata' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function version()
    {
        return $this->belongsTo(CourseVersion::class, 'course_version_id');
    }

    public function parent()
    {
        return $this->belongsTo(CourseModule::class, 'parent_module_id');
    }

    public function children()
    {
        return $this->hasMany(CourseModule::class, 'parent_module_id');
    }

    public function lessons()
    {
        return $this->hasMany(CourseLesson::class, 'module_id');
    }
}
