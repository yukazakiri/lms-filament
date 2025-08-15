<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasUuid;

class Course extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid','organization_id','category_id','code','title','slug','subtitle','description','objectives','prerequisites','target_audience','difficulty_level','estimated_duration','language','thumbnail_url','trailer_url','status','type','delivery_method','max_enrollments','price','currency','is_free','is_featured','is_public','requires_approval','certificate_template_id','completion_criteria','tags','metadata','seo_title','seo_description','seo_keywords','created_by','updated_by','published_at','archived_at'
    ];

    protected $casts = [
        'completion_criteria' => 'array',
        'tags' => 'array',
        'metadata' => 'array',
        'is_free' => 'boolean',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'requires_approval' => 'boolean',
        'published_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function versions()
    {
        return $this->hasMany(CourseVersion::class);
    }

    public function modules()
    {
        return $this->hasMany(CourseModule::class);
    }

    public function activities()
    {
        return $this->hasMany(CourseActivity::class);
    }

    public function resources()
    {
        return $this->hasMany(CourseResource::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
