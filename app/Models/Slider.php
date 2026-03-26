<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Slider extends Model {
    protected $fillable = ['title', 'image', 'link', 'sort_order', 'is_active', 'created_by', 'updated_by'];
    protected $casts = ['is_active' => 'boolean'];
    public function getImageUrlAttribute() {
        if ($this->image && file_exists(public_path('storage/sliders/' . $this->image))) return asset('storage/sliders/' . $this->image);
        return asset('images/slider-placeholder.jpg');
    }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
}
