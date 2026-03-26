<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AwardParticipant extends Model {
    protected $fillable = ['award_id', 'name', 'category', 'class', 'school', 'district', 'state', 'month', 'photo', 'cert_number', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function award() { return $this->belongsTo(Award::class); }

    public function getPhotoUrlAttribute() {
        if ($this->photo) return asset('storage/award_participants/' . $this->photo);
        return asset('images/default-avatar.png');
    }

    // Auto generate cert number on create
    protected static function booted() {
        static::creating(function ($p) {
            if (empty($p->cert_number)) {
                $p->cert_number = 'CERT-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
