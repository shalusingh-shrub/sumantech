<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model {
    protected $fillable = [
        'user_id','registration_number','registration_date','avatar','image',
        'aadhaar_number','aadhaar_card','status','gender','dob','father_name','mother_name',
        'alternate_mobile','mobile','whatsapp','state','district','block','pincode',
        'panchayat','village','address','highest_education','college',
        'subject','pass_year','designation','department','school','class',
        'employee_id','bio','facebook','twitter','instagram','linkedin','youtube'
    ];
    protected $casts = ['dob' => 'date', 'registration_date' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function getAvatarUrlAttribute() {
        return $this->avatar ? asset('storage/'.$this->avatar) : null;
    }

    public function getPhotoUrlAttribute() {
        if ($this->image) return asset('storage/'.$this->image);
        if ($this->avatar) return asset('storage/'.$this->avatar);
        return null;
    }

    public function getAadhaarUrlAttribute() {
        return $this->aadhaar_card ? asset('storage/'.$this->aadhaar_card) : null;
    }
}
