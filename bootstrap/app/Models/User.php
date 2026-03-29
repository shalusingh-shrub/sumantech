<?php
// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'designation',
        'department',
        'about',
        'is_active',
        'api_token',   // ← API authentication ke liye
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'api_token',   // ← Response mein kabhi nahi dikhega
    ];
    //   'name','email','password','phone','avatar',
    //     'designation','department','about','is_active',
    //     'user_type','district','school','class','can_access_admin',
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }
}
