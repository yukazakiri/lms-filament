<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasUuid;

class CourseLesson extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid','module_id','title','description','content','content_type','content_url','content_metadata','estimated_duration','sort_order','is_required','is_active','is_preview','unlock_conditions','completion_criteria','resources','notes'
    ];

    protected $casts = [
        'content_metadata' => 'array',
        'unlock_conditions' => 'array',
        'completion_criteria' => 'array',
        'resources' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'is_preview' => 'boolean',
    ];

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function activities()
    {
        return $this->hasMany(CourseActivity::class, 'lesson_id');
    }
}
