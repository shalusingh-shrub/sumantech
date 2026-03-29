<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    protected $fillable = [
        'student_id', 'course_id', 'amount', 'start_date', 'end_date',
        'reg_date', 'certificate_id', 'certificate_issue_date',
        'certificate_image', 'marks', 'tally_details',
        'certificate_receiving_date', 'regenerate_certificate',
        'status', 'cert_status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'reg_date' => 'date',
        'certificate_issue_date' => 'date',
        'certificate_receiving_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public static function generateCertificateId()
    {
        $prefix = 'ST-' . date('dm');
        $rand = rand(100000, 999999);
        $id = $prefix . $rand;
        while (self::where('certificate_id', $id)->exists()) {
            $id = $prefix . rand(100000, 999999);
        }
        return $id;
    }
}
