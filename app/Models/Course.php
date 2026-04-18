<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'duration', 'fee', 'is_active',
        'description', 'image', 'highlights',
        'syllabus', 'course_level', 'career_opportunities', 'eligibility',
    ];

    protected $casts = [
    'syllabus'  => 'array',
    'is_active' => 'boolean',
];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }
}