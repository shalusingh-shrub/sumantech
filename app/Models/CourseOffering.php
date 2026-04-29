<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseOffering extends Model
{
    protected $fillable = [
        'course_id',
        'duration_value',
        'duration_unit',
        'is_active',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'duration_value' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function priceHistories(): HasMany
    {
        return $this->hasMany(CoursePriceHistory::class);
    }

    public function currentPrice(): ?CoursePriceHistory
    {
        return $this->priceHistories()
            ->whereNull('effective_to')
            ->latest('effective_from')
            ->first();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(UserCourseEnrollment::class);
    }

    public function getDurationLabelAttribute(): string
    {
        return $this->duration_value . ' ' . ucfirst($this->duration_unit);
    }
}