<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Course extends Model
{
    protected $fillable = [
        'name', 'duration', 'fee', 'is_active',
        'description', 'image', 'highlights'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }
}