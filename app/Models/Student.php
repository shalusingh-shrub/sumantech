<?php
// app/Models/Student.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'registration_number',
        'registration_date',
        'name',
        'father_name',
        'date_of_birth',
        'email',
        'mobile',
        'whatsapp',
        'address',
        'image',
        'aadhaar_number',
        'aadhaar_card',
        'gender',
        'password',
        'status',
    ];

    public function courses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/students/' . $this->image)
            : asset('images/default-avatar.png');
    }

    public function getAadhaarUrlAttribute(): ?string
    {
        return $this->aadhaar_card
            ? asset('storage/students/aadhaar/' . $this->aadhaar_card)
            : null;
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->status === 'active' ? 'Active' : 'Inactive';
    }
}
