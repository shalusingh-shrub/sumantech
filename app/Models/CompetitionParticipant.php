<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CompetitionParticipant extends Model {
    protected $fillable = ['competition_id', 'name', 'email', 'phone', 'school', 'district', 'category', 'submission_file', 'status', 'remarks', 'cert_number', 'generated_certificate'];
    public function competition() { return $this->belongsTo(Competition::class); }
}
