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
        'class', 'can_access_admin', 'role',
        'registration_number', 'registration_date',
        'father_name', 'date_of_birth', 'mobile', 'whatsapp',
        'address', 'gender', 'image', 'aadhaar_number',
        'aadhaar_card', 'status',
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

    // Role helpers
    public function isAdmin()    { return $this->role === 'admin'; }
    public function isStudent()  { return $this->role === 'student'; }
    public function isTeacher()  { return $this->role === 'teacher'; }

    // Student courses
    public function courses()
    {
        return $this->hasMany(StudentCourse::class, 'user_id');
    }

    // Invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id');
    }

    // Student marks
    public function marks()
    {
        return $this->hasMany(StudentMark::class, 'student_id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->image) return asset('storage/' . $this->image);
        if ($this->avatar) return asset('storage/' . $this->avatar);
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=90&background=1a2a6c&color=fff';
    }

    public function getAvatarUrlAttribute()
    {
        return $this->photo_url;
    }

    public static function generateRegNumber($dob = null)
{
    if ($dob) {
        $dobFormatted = \Carbon\Carbon::parse($dob)->format('dmY');
    } else {
        $dobFormatted = now()->format('dmY');
    }
    do {
        $rand = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $reg  = 'ST-' . $dobFormatted . '-' . $rand;
    } while (self::where('registration_number', $reg)->exists());
    return $reg;
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