<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePriceRequest;
use App\Models\CourseOffering;
use App\Services\CoursePricingService;

class CoursePricingController extends Controller
{
    public function __construct(
        private CoursePricingService $pricingService
    ) {}

    public function index(CourseOffering $courseOffering)
    {
        $currentPrice = $this->pricingService->getCurrentPrice($courseOffering);
        $priceHistory = $this->pricingService->getPriceHistory($courseOffering);

        return view('admin.course_offerings.pricing', compact(
            'courseOffering', 'currentPrice', 'priceHistory'
        ));
    }

    public function update(UpdatePriceRequest $request, CourseOffering $courseOffering)
    {
        $this->pricingService->updatePrice($courseOffering, $request->price);

        return redirect()->route('admin.course-offerings.pricing', $courseOffering)
            ->with('success', 'Price updated successfully! Purane enrollments pe koi asar nahi.');
    }
}