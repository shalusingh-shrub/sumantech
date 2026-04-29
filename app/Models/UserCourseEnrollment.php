<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCourseEnrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_offering_id',
        'price_locked',
        'price_source_id',
        'duration_value',
        'duration_unit',
        'start_date',
        'end_date',
        'enrolled_at',
    ];

    protected $casts = [
        'price_locked'   => 'decimal:2',
        'duration_value' => 'integer',
        'start_date'     => 'datetime',
        'end_date'       => 'datetime',
        'enrolled_at'    => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courseOffering(): BelongsTo
    {
        return $this->belongsTo(CourseOffering::class);
    }

    public function priceSource(): BelongsTo
    {
        return $this->belongsTo(CoursePriceHistory::class, 'price_source_id');
    }

    public function getDurationLabelAttribute(): string
    {
        return $this->duration_value . ' ' . ucfirst($this->duration_unit);
    }

    public function getIsActiveAttribute(): bool
    {
        return now()->between($this->start_date, $this->end_date);
    }
}