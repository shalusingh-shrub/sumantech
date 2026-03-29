<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TeamMember extends Model {
    protected $fillable = ['name', 'designation', 'department', 'phone', 'email', 'about', 'photo', 'role_type', 'sort_order', 'is_active', 'created_by', 'updated_by'];
    protected $casts = ['is_active' => 'boolean'];
    public function getPhotoUrlAttribute(): string {
        if ($this->photo && file_exists(public_path('storage/team/' . $this->photo))) return asset('storage/team/' . $this->photo);
        return asset('images/default-avatar.png');
    }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
}
