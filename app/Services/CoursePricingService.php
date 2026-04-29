<?php
namespace App\Services;

use App\Models\CourseOffering;
use App\Models\CoursePriceHistory;
use Illuminate\Support\Facades\DB;

class CoursePricingService
{
    public function getCurrentPrice(CourseOffering $offering): ?CoursePriceHistory
    {
        return CoursePriceHistory::where('course_offering_id', $offering->id)
            ->whereNull('effective_to')
            ->latest('effective_from')
            ->first();
    }

    public function updatePrice(CourseOffering $offering, float $newPrice): CoursePriceHistory
    {
        return DB::transaction(function () use ($offering, $newPrice) {
            // Old price band karo
            CoursePriceHistory::where('course_offering_id', $offering->id)
                ->whereNull('effective_to')
                ->update(['effective_to' => now()]);

            // Naya price add karo
            return CoursePriceHistory::create([
                'course_offering_id' => $offering->id,
                'price'              => $newPrice,
                'effective_from'     => now(),
                'effective_to'       => null,
            ]);
        });
    }

    public function getPriceHistory(CourseOffering $offering)
    {
        return CoursePriceHistory::where('course_offering_id', $offering->id)
            ->latest('effective_from')
            ->get();
    }
}