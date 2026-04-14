<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CourseCategory extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image',
        'color', 'icon', 'sort_order', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) return asset('storage/' . $this->image);
        return null;
    }
}