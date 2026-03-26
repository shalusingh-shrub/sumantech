<?php
// File: app/Models/NewsEvent.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class NewsEvent extends Model {
    protected $fillable = ['title', 'slug', 'short_description', 'excerpt', 'content', 'image', 'category', 'news_category_id', 'event_date', 'is_published', 'pin_to_home', 'publish_date', 'meta_title', 'meta_description', 'meta_keywords'];
    protected $casts = ['is_published' => 'boolean', 'pin_to_home' => 'boolean', 'event_date' => 'date', 'publish_date' => 'date'];

    public function newsCategory() {
        return $this->belongsTo(\App\Models\NewsCategory::class, 'news_category_id');
    }
    public function getImageUrlAttribute() {
        if ($this->image) return asset('storage/news/' . $this->image);
        return asset('images/news-placeholder.jpg');
    }
}
