<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentMark extends Model {
    protected $fillable = ['student_course_id', 'subject_name', 'max_marks', 'obtained_marks'];

    public function studentCourse() {
        return $this->belongsTo(StudentCourse::class);
    }

    public function getPercentageAttribute() {
        return $this->max_marks > 0 ? round(($this->obtained_marks / $this->max_marks) * 100, 2) : 0;
    }
}