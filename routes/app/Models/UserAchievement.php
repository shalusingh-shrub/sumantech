<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model {
    protected $fillable = ['user_id','title','category','achievement_type','description','achievement_date','file'];
    protected $casts = ['achievement_date' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function getFileUrlAttribute() {
        return $this->file ? asset('storage/'.$this->file) : null;
    }
    public function isImage() {
        if(!$this->file) return false;
        $ext = pathinfo($this->file, PATHINFO_EXTENSION);
        return in_array(strtolower($ext), ['jpg','jpeg','png','gif','webp']);
    }
}
