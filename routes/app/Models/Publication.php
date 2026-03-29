<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Publication extends Model {
    protected $fillable = ['title', 'slug', 'description', 'cover_image', 'file', 'category', 'issue_number', 'published_date', 'is_active', 'created_by', 'updated_by'];
    protected $casts = ['is_active' => 'boolean', 'published_date' => 'date'];
    public function getImageUrlAttribute() {
        if ($this->cover_image) return asset('storage/publications/' . $this->cover_image);
        return asset('images/pub-placeholder.jpg');
    }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
}
