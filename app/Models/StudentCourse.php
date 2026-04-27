<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'course_name',
        'course_duration',
        'amount',
        'discount',
        'start_date',
        'end_date',
        'reg_date',
        'certificate_id',
        'certificate_issue_date',
        'certificate_image',
        'marks',
        'tally_details',
        'certificate_receiving_date',
        'regenerate_certificate',
        'status',
        'cert_status',
    ];

    protected $casts = [
        'start_date'                 => 'date',
        'end_date'                   => 'date',
        'reg_date'                   => 'date',
        'certificate_issue_date'     => 'date',
        'certificate_receiving_date' => 'date',
        'regenerate_certificate'     => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($course) {
            if (empty($course->certificate_id)) {
                do {
                    $id = 'ST-' . random_int(1000000000, 9999999999);
                } while (self::where('certificate_id', $id)->exists());
                $course->certificate_id = $id;
            }
        });
    }

    // User se linked (student)
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function studentMarks()
    {
        return $this->hasMany(StudentMark::class);
    }

    public function getFinalAmountAttribute(): float
    {
        return ($this->amount ?? 0) - ($this->discount ?? 0);
    }
}