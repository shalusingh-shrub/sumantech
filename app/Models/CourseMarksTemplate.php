<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CourseMarksTemplate extends Model
{
    protected $table = 'course_marks_templates';

    protected $fillable = [
        'template_id', 'course_id', 'course_name', 'subjects',
        'grade_standards', 'notes',
    ];

    protected static function booted(): void
    {
        static::creating(function ($template) {
            if (empty($template->template_id)) {
                do {
                    $id = 'TEMP-' . strtoupper(substr(preg_replace('/[^A-Z0-9]/i', '', $template->course_name), 0, 4)) . '-' . date('Y') . '-' . rand(100, 999);
                } while (self::where('template_id', $id)->exists());
                $template->template_id = $id;
            }
        });
    }

    protected $casts = [
        'subjects'        => 'json',
        'grade_standards' => 'json',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getTotalMaxMarksAttribute()
    {
        return collect($this->subjects)->sum('max_marks');
    }

    public function calculateGrade($percentage)
    {
        if (!$this->grade_standards) return ['grade' => 'N/A', 'result' => 'N/A'];

        foreach ($this->grade_standards as $standard) {
            if ($percentage >= $standard['min'] && $percentage <= $standard['max']) {
                return [
                    'grade'  => $standard['grade'],
                    'result' => $standard['result'],
                ];
            }
        }
        return ['grade' => 'F', 'result' => 'Fail'];
    }
}