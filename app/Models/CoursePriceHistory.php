<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoursePriceHistory extends Model
{
    protected $fillable = [
        'course_offering_id',
        'price',
        'effective_from',
        'effective_to',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'effective_from' => 'datetime',
        'effective_to'   => 'datetime',
    ];

    public function courseOffering(): BelongsTo
    {
        return $this->belongsTo(CourseOffering::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(UserCourseEnrollment::class, 'price_source_id');
    }

    public function isActive(): bool
    {
        return is_null($this->effective_to);
    }
}