<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid','user_id','course_id','enrollment_id','session_token','started_at','ended_at','duration','ip_address','user_agent','device_type','browser','platform','location','activities_completed','lessons_viewed','interactions_count','idle_time','session_data'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'session_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(CourseEnrollment::class, 'enrollment_id');
    }
}
