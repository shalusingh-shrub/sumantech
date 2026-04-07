<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'registration_number', 'registration_date', 'name', 'father_name',
        'date_of_birth', 'email', 'mobile', 'whatsapp', 'address',
        'image', 'aadhaar_number', 'aadhaar_card', 'gender', 'password', 'status'
    ];

    protected $hidden = ['password'];

    protected $dates = ['deleted_at'];

    public function courses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id');
    }

    public static function generateRegNumber()
    {
        $prefix = 'ST-' . date('dm');
        $rand = rand(100000, 999999);
        $reg = $prefix . $rand;
        while (self::where('registration_number', $reg)->exists()) {
            $reg = $prefix . rand(100000, 999999);
        }
        return $reg;
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=42&background=1a2a6c&color=fff';
    }
}
