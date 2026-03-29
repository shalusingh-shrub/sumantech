<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Gallery extends Model {
    protected $fillable = ['title', 'image', 'video_url', 'type', 'category', 'is_active', 'created_by', 'updated_by'];
    protected $casts = ['is_active' => 'boolean'];
    public function getImageUrlAttribute() {
        if ($this->image) return asset('storage/gallery/' . $this->image);
        return asset('images/gallery-placeholder.jpg');
    }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
}
