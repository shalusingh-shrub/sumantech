<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable = [
        'quiz_id', 'participant_name', 'participant_email',
        'participant_phone', 'user_id', 'total_questions',
        'attempted', 'correct', 'wrong', 'score', 'total_marks',
        'percentage', 'grade', 'result', 'time_taken',
        'answers', 'ip_address',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

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
}