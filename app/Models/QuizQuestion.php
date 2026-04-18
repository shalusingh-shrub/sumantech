<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = [
        'quiz_id', 'question', 'question_type', 'explanation',
        'image', 'points', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options()
    {
        return $this->hasMany(QuizOption::class, 'question_id')->orderBy('sort_order');
    }

    public function correctOption()
    {
        return $this->hasOne(QuizOption::class, 'question_id')->where('is_correct', true);
    }
}