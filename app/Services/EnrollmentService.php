<?php
namespace App\Services;

use App\Models\CourseOffering;
use App\Models\UserCourseEnrollment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class EnrollmentService
{
    public function __construct(
        private CoursePricingService $pricingService
    ) {}

    public function enroll(User $user, CourseOffering $offering): UserCourseEnrollment
    {
        return DB::transaction(function () use ($user, $offering) {

            // Current price fetch karo
            $currentPrice = $this->pricingService->getCurrentPrice($offering);

            if (!$currentPrice) {
                throw new Exception('Is course ka koi active price nahi hai!');
            }

            // Start date aur end date calculate karo
            $startDate = now();
            $endDate   = $this->calculateEndDate($startDate, $offering->duration_value, $offering->duration_unit);

            // Enrollment create karo
            return UserCourseEnrollment::create([
                'user_id'            => $user->id,
                'course_offering_id' => $offering->id,
                'price_locked'       => $currentPrice->price,
                'price_source_id'    => $currentPrice->id,
                'duration_value'     => $offering->duration_value,
                'duration_unit'      => $offering->duration_unit,
                'start_date'         => $startDate,
                'end_date'           => $endDate,
                'enrolled_at'        => now(),
            ]);
        });
    }

    private function calculateEndDate(Carbon $startDate, int $value, string $unit): Carbon
    {
        return match($unit) {
            'days'   => $startDate->copy()->addDays($value),
            'weeks'  => $startDate->copy()->addWeeks($value),
            'months' => $startDate->copy()->addMonths($value),
            'years'  => $startDate->copy()->addYears($value),
            default  => $startDate->copy()->addMonths($value),
        };
    }

    public function getUserEnrollments(User $user)
    {
        return UserCourseEnrollment::with(['courseOffering.course', 'priceSource'])
            ->where('user_id', $user->id)
            ->latest('enrolled_at')
            ->get();
    }

    public function isAlreadyEnrolled(User $user, CourseOffering $offering): bool
    {
        return UserCourseEnrollment::where('user_id', $user->id)
            ->where('course_offering_id', $offering->id)
            ->exists();
    }
}