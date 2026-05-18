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
        'subjects'        => 'array',
        'grade_standards' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getTotalMaxMarksAttribute()
    {
        $subjects = is_array($this->subjects) ? $this->subjects : [];
        return collect($subjects)->sum('max_marks');
    }

    public function calculateGrade($percentage)
    {
        $standards = $this->grade_standards;

        if (is_string($standards)) {
            $standards = json_decode($standards, true);
        }

        if (!$standards || !is_array($standards)) {
            return ['grade' => 'N/A', 'result' => 'N/A'];
        }

        foreach ($standards as $standard) {
            if (isset($standard['min'], $standard['max']) &&
                $percentage >= $standard['min'] &&
                $percentage <= $standard['max']) {
                return [
                    'grade'  => $standard['grade'] ?? 'N/A',
                    'result' => $standard['result'] ?? 'N/A',
                ];
            }
        }

        return ['grade' => 'F', 'result' => 'Fail'];
    }
}