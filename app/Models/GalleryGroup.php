<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryGroup extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'start_date', 'end_date',
        'description', 'meta_data', 'meta_keyword',
        'cover_image', 'pin_to_home', 'is_active'
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'pin_to_home'  => 'boolean',
        'start_date'   => 'date',
        'end_date'     => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function items()
    {
        return $this->hasMany(GalleryItem::class)->orderBy('sort_order');
    }

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) return asset('storage/' . $this->cover_image);
        // First item ki image return karo agar cover nahi hai
        $first = $this->items()->whereNotNull('file_path')->first();
        if ($first) return asset('storage/' . $first->file_path);
        return null;
    }
}