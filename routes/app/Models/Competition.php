<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model {
    protected $fillable = [
        'title', 'slug', 'description', 'image',
        'start_date', 'end_date', 'result_date', 'last_date',
        'registration_link', 'is_active', 'created_by', 'updated_by',
        'event_selection_category', 'participation_category',
        'winner_certificate', 'participation_certificate', 'audience_certificate',
        'is_participation_cert_allow', 'is_auto_gen_certificate', 'cert_layout'
    ];
    protected $casts = [
        'is_active'                   => 'boolean',
        'is_participation_cert_allow' => 'boolean',
        'is_auto_gen_certificate'     => 'boolean',
        'start_date'                  => 'date',
        'end_date'                    => 'date',
        'result_date'                 => 'date',
        'last_date'                   => 'date',
    ];

    public function getImageUrlAttribute() { return $this->image ? asset('storage/competitions/' . $this->image) : asset('images/comp-placeholder.jpg'); }
    public function getWinnerCertUrlAttribute() { return $this->winner_certificate ? asset('storage/competitions/certificates/' . $this->winner_certificate) : null; }
    public function getParticipationCertUrlAttribute() { return $this->participation_certificate ? asset('storage/competitions/certificates/' . $this->participation_certificate) : null; }
    public function getAudienceCertUrlAttribute() { return $this->audience_certificate ? asset('storage/competitions/certificates/' . $this->audience_certificate) : null; }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
    public function participants() { return $this->hasMany(CompetitionParticipant::class); }
}
