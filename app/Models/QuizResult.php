<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuizResult extends Model
{
    protected $fillable = [
        'quiz_id', 'participant_name', 'participant_email',
        'participant_phone', 'participant_school', 'user_id',
        'total_questions', 'attempted', 'correct', 'wrong',
        'score', 'total_marks', 'percentage', 'grade', 'result',
        'time_taken', 'answers', 'ip_address',
        'certificate_number', 'certificate_downloaded_at',
    ];

    protected $casts = [
        'answers'                    => 'array',
        'certificate_downloaded_at'  => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->certificate_number) {
                $model->certificate_number = strtoupper(Str::random(8));
            }
        });
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function getGradeAttribute($value)
    {
        if ($value) return $value;
        if ($this->percentage >= 90) return 'A+';
        if ($this->percentage >= 80) return 'A';
        if ($this->percentage >= 70) return 'B';
        if ($this->percentage >= 60) return 'C';
        if ($this->percentage >= 50) return 'D';
        return 'F';
    }

    public function getTimeTakenFormattedAttribute()
    {
        $m = floor($this->time_taken / 60);
        $s = $this->time_taken % 60;
        return $m . 'm ' . $s . 's';
    }
}