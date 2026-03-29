<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'duration', 'fee', 'is_active'];

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }
}
