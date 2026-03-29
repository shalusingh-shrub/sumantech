<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Testimonial extends Model {
    protected $fillable = ['name', 'designation', 'organization', 'content', 'photo', 'rating', 'is_active', 'created_by', 'updated_by'];
    protected $casts = ['is_active' => 'boolean'];
    public function getPhotoUrlAttribute() {
        if ($this->photo) return asset('storage/testimonials/' . $this->photo);
        return asset('images/default-avatar.png');
    }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
}
