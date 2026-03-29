<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class EipResource extends Model {
    protected $table = 'eip_resources';
    protected $fillable = ['title', 'slug', 'description', 'image', 'link', 'category', 'is_active', 'created_by', 'updated_by'];
    protected $casts = ['is_active' => 'boolean'];
    public function getImageUrlAttribute() {
        if ($this->image) return asset('storage/eip/' . $this->image);
        return asset('images/eip-placeholder.jpg');
    }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
}
