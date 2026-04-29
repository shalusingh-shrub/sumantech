<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCourseOfferingRequest;
use App\Models\Course;
use App\Models\CourseOffering;
use App\Services\CoursePricingService;
use Illuminate\Http\Request;

class CourseOfferingController extends Controller
{
    public function __construct(
        private CoursePricingService $pricingService
    ) {}

    public function index()
    {
        $offerings = CourseOffering::with(['course', 'priceHistories' => function($q) {
            $q->whereNull('effective_to');
        }])
        ->latest()
        ->paginate(10);

        return view('admin.course_offerings.index', compact('offerings'));
    }

    public function create()
    {
        $courses = Course::where('is_active', true)->orderBy('name')->get();
        return view('admin.course_offerings.create', compact('courses'));
    }

    public function store(StoreCourseOfferingRequest $request)
    {
        $offering = CourseOffering::create([
            'course_id'      => $request->course_id,
            'duration_value' => $request->duration_value,
            'duration_unit'  => $request->duration_unit,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        // Initial price set karo
        $this->pricingService->updatePrice($offering, $request->price);

        return redirect()->route('admin.course-offerings.index')
            ->with('success', 'Course Offering created successfully!');
    }

    public function show(CourseOffering $courseOffering)
    {
        $courseOffering->load('course');
        $currentPrice = $this->pricingService->getCurrentPrice($courseOffering);
        $priceHistory = $this->pricingService->getPriceHistory($courseOffering);
        $enrollments  = $courseOffering->enrollments()->with('user')->latest()->get();

        return view('admin.course_offerings.show', compact(
            'courseOffering', 'currentPrice', 'priceHistory', 'enrollments'
        ));
    }

    public function edit(CourseOffering $courseOffering)
    {
        $courses      = Course::where('is_active', true)->orderBy('name')->get();
        $currentPrice = $this->pricingService->getCurrentPrice($courseOffering);
        return view('admin.course_offerings.edit', compact('courseOffering', 'courses', 'currentPrice'));
    }

    public function update(Request $request, CourseOffering $courseOffering)
    {
        $request->validate([
            'duration_value' => 'required|integer|min:1',
            'duration_unit'  => 'required|in:days,weeks,months,years',
            'is_active'      => 'boolean',
        ]);

        $courseOffering->update([
            'duration_value' => $request->duration_value,
            'duration_unit'  => $request->duration_unit,
            'is_active'      => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.course-offerings.index')
            ->with('success', 'Course Offering updated!');
    }

    public function destroy(CourseOffering $courseOffering)
    {
        $courseOffering->delete();
        return redirect()->route('admin.course-offerings.index')
            ->with('success', 'Course Offering deleted!');
    }
}