<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'title', 'description', 'category', 'thumbnail',
        'time_limit', 'pass_percentage', 'randomize_questions',
        'randomize_options', 'show_result', 'allow_retake',
        'start_date', 'end_date', 'status', 'created_by',
    ];

    protected $casts = [
        'randomize_questions' => 'boolean',
        'randomize_options'   => 'boolean',
        'show_result'         => 'boolean',
        'allow_retake'        => 'boolean',
        'start_date'          => 'date',
        'end_date'            => 'date',
    ];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('sort_order');
    }

    public function results()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function getTotalQuestionsAttribute()
    {
        return $this->questions()->where('is_active', true)->count();
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail
            ? asset('storage/'.$this->thumbnail)
            : null;
    }
}