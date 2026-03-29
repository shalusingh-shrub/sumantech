<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Magazine extends Model {
    protected $fillable = ['title', 'magazine_category_id', 'image', 'file', 'magazine_date', 'is_active', 'description', 'created_by', 'updated_by'];
    protected $casts = ['is_active' => 'boolean', 'magazine_date' => 'date'];
    public function category() { return $this->belongsTo(MagazineCategory::class, 'magazine_category_id'); }
    public function getImageUrlAttribute() { return $this->image ? asset('storage/magazines/' . $this->image) : asset('images/magazine-placeholder.jpg'); }
    public function getFileUrlAttribute() { return $this->file ? asset('storage/magazines/files/' . $this->file) : null; }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
}
