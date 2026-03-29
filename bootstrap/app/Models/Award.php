<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Award extends Model {
    protected $fillable = ['title', 'slug', 'description', 'image', 'year', 'is_active', 'certificate_template', 'has_certificate', 'created_by', 'updated_by', 'cert_layout'];
    protected $casts = ['is_active' => 'boolean', 'has_certificate' => 'boolean'];

    public function getImageUrlAttribute() {
        if ($this->image) return asset('storage/awards/' . $this->image);
        return asset('images/award-placeholder.jpg');
    }
    public function getCertificateUrlAttribute() {
        if ($this->certificate_template) return asset('storage/awards/certificates/' . $this->certificate_template);
        return null;
    }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
    public function participants() { return $this->hasMany(AwardParticipant::class); }
}
