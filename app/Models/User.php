<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar',
        'designation', 'department', 'about', 'is_active',
        'api_token', 'user_type', 'district', 'school',
        'class', 'can_access_admin',
    ];

    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->profile && $this->profile->avatar) {
            return asset('storage/' . $this->profile->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=90&background=1a2a6c&color=fff';
    }

    public function profile()
    {
        return $this->hasOne(\App\Models\UserProfile::class);
    }

    public function achievements()
    {
        return $this->hasMany(\App\Models\UserAchievement::class);
    }

    public function activities()
    {
        return $this->hasMany(\App\Models\UserActivity::class);
    }
}