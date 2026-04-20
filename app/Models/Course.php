<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = [
        'name', 'slug', 'duration', 'fee', 'is_active',
        'description', 'image', 'highlights',
        'syllabus', 'course_level', 'career_opportunities', 'eligibility'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
        static::updating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function categories()
    {
        return $this->hasMany(CourseCategory::class)->orderBy('sort_order');
    }
}