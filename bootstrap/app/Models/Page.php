<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Page extends Model {
    protected $fillable = ['title', 'slug', 'content', 'banner_image', 'is_active', 'created_by', 'updated_by'];
    protected $casts = ['is_active' => 'boolean'];
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
}
