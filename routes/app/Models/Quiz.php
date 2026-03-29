<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model {
    protected $fillable = ['quiz_name', 'description', 'quiz_views', 'quiz_taken', 'last_activity', 'is_active', 'created_by', 'updated_by'];
    protected $casts = ['is_active' => 'boolean', 'last_activity' => 'datetime'];

    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
}
