<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasUuid;

class CourseCategory extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid','parent_id','organization_id','name','slug','description','icon','color','sort_order','is_active','metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(CourseCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CourseCategory::class, 'parent_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }
}
