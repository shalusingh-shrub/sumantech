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
        'name', 'email', 'password', 'phone', 'is_active',
        'api_token', 'user_type', 'can_access_admin', 'role',
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
        return $this->hasManyThrough(StudentMark::class, StudentCourse::class, 'user_id', 'student_course_id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->profile && $this->profile->image) return asset('storage/' . $this->profile->image);
        if ($this->profile && $this->profile->avatar) return asset('storage/' . $this->profile->avatar);
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
        $reg  = 'ST-' . $dobFormatted  . $rand;
    } while (UserProfile::where('registration_number', $reg)->exists());
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

    public function getRegistrationNumberAttribute() { return $this->profileValue('registration_number'); }
    public function getRegistrationDateAttribute() { return $this->profileValue('registration_date'); }
    public function getFatherNameAttribute() { return $this->profileValue('father_name'); }
    public function getDateOfBirthAttribute() { return $this->profileValue('dob'); }
    public function getMobileAttribute() { return $this->profileValue('mobile') ?: $this->phone; }
    public function getWhatsappAttribute() { return $this->profileValue('whatsapp'); }
    public function getAddressAttribute() { return $this->profileValue('address'); }
    public function getGenderAttribute() { return $this->profileValue('gender'); }
    public function getDistrictAttribute() { return $this->profileValue('district'); }
    public function getSchoolAttribute() { return $this->profileValue('school'); }
    public function getClassAttribute() { return $this->profileValue('class'); }
    public function getImageAttribute() { return $this->profileValue('image'); }
    public function getAvatarAttribute() { return $this->profileValue('avatar'); }
    public function getAadhaarNumberAttribute() { return $this->profileValue('aadhaar_number'); }
    public function getAadhaarCardAttribute() { return $this->profileValue('aadhaar_card'); }
    public function getStatusAttribute() { return $this->profileValue('status') ?: ($this->is_active ? 'active' : 'inactive'); }
    public function getAadhaarUrlAttribute()
    {
        return $this->aadhaar_card ? asset('storage/' . $this->aadhaar_card) : null;
    }

    private function profileValue(string $key)
    {
        $profile = $this->relationLoaded('profile') ? $this->relations['profile'] : $this->profile;
        return $profile?->{$key};
    }
}
