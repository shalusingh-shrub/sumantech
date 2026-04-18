<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quiz extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'category', 'thumbnail',
        'time_limit', 'pass_percentage', 'randomize_questions',
        'randomize_options', 'show_result', 'allow_retake',
        'start_date', 'end_date', 'status', 'created_by',
        'certificate_title', 'certificate_message',
    ];

    protected $casts = [
        'randomize_questions' => 'boolean',
        'randomize_options'   => 'boolean',
        'show_result'         => 'boolean',
        'allow_retake'        => 'boolean',
        'start_date'          => 'date',
        'end_date'            => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
    if (!$model->slug) {
        $base = Str::slug($model->title);
        $slug = $base;
        $i = 1;
        while (\App\Models\Quiz::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        $model->slug = $slug;
    }
});
    }

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
        return $this->thumbnail ? asset('storage/'.$this->thumbnail) : null;
    }

    // Ek email ne kitni baar diya
    public function attemptsByEmail($email)
    {
        return $this->results()->where('participant_email', $email)->count();
    }
}