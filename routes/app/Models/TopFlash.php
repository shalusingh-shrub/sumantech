<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TopFlash extends Model {
    protected $fillable = ['title', 'link', 'is_new', 'sort_order', 'is_active', 'created_by', 'updated_by'];
    protected $casts = ['is_new' => 'boolean', 'is_active' => 'boolean'];
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
}
