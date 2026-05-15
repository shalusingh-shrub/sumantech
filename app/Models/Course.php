<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = [
        'name', 'slug', 'duration', 'fee', 'is_active',
        'description', 'image', 'highlights',
        'syllabus', 'course_level', 'career_opportunities', 'eligibility',
        'badge_label', 'icon_class', 'card_color'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'syllabus' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
        static::updating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }

    public function getHomepageBadgeAttribute()
    {
        if ($this->badge_label) {
            return $this->badge_label;
        }

        $name = strtolower($this->name);

        return match (true) {
            str_contains($name, 'dca') && !str_contains($name, 'adca') => 'Popular',
            str_contains($name, 'adca') => 'Bestseller',
            str_contains($name, 'tally') => 'Job Ready',
            str_contains($name, 'digita') || str_contains($name, 'digital') => 'New',
            default => $this->course_level,
        };
    }

    public function getHomepageIconAttribute()
    {
        if ($this->icon_class) {
            return $this->icon_class;
        }

        $name = strtolower($this->name);

        return match (true) {
            str_contains($name, 'tally') || str_contains($name, 'account') => 'fa-calculator',
            str_contains($name, 'web') || str_contains($name, 'html') || str_contains($name, 'program') => 'fa-code',
            str_contains($name, 'digital') => 'fa-bullhorn',
            str_contains($name, 'tax') || str_contains($name, 'gst') => 'fa-file-invoice-dollar',
            str_contains($name, 'adca') => 'fa-laptop',
            default => 'fa-desktop',
        };
    }

    public function getHomepageColorAttribute()
    {
        if ($this->card_color) {
            return $this->card_color;
        }

        $name = strtolower($this->name);

        return match (true) {
            str_contains($name, 'adca') => '#1557B0',
            str_contains($name, 'tally') || str_contains($name, 'account') => '#0E6B50',
            str_contains($name, 'digital') => '#3D1F6B',
            str_contains($name, 'web') || str_contains($name, 'html') => '#0B4D6C',
            str_contains($name, 'tax') || str_contains($name, 'gst') => '#6B1F3A',
            default => '#0B3D8C',
        };
    }

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function categories()
    {
        return $this->hasMany(CourseCategory::class)->orderBy('sort_order');
    }
}
