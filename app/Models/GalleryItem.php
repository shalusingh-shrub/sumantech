<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryItem extends Model
{
    protected $fillable = [
        'gallery_group_id', 'title', 'slug',
        'file_path', 'video_url', 'video_file',
        'sort_order', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->slug && $model->title) {
                $model->slug = Str::slug($model->title) . '-' . uniqid();
            }
        });
    }

    public function group()
    {
        return $this->belongsTo(GalleryGroup::class, 'gallery_group_id');
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_path) return asset('storage/' . $this->file_path);
        return null;
    }

    public function getVideoFileUrlAttribute()
    {
        if ($this->video_file) return asset('storage/' . $this->video_file);
        return null;
    }
}