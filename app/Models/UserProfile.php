<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model {
    protected $fillable = [
        'user_id','avatar','gender','dob','father_name','mother_name',
        'alternate_mobile','state','district','block','pincode',
        'panchayat','village','address','highest_education','college',
        'subject','pass_year','designation','department','school',
        'employee_id','bio','facebook','twitter','instagram','linkedin','youtube'
    ];
    protected $casts = ['dob' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function getAvatarUrlAttribute() {
        return $this->avatar ? asset('storage/'.$this->avatar) : null;
    }
}
