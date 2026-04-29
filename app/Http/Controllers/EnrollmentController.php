<?php
namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use App\Models\CourseOffering;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function __construct(
        private EnrollmentService $enrollmentService
    ) {}

    public function index()
    {
        $enrollments = $this->enrollmentService->getUserEnrollments(auth()->user());
        return view('enrollments.index', compact('enrollments'));
    }

    public function store(EnrollmentRequest $request)
    {
        $offering = CourseOffering::findOrFail($request->course_offering_id);

        if ($this->enrollmentService->isAlreadyEnrolled(auth()->user(), $offering)) {
            return redirect()->back()->with('error', 'Aap already is course mein enrolled hain!');
        }

        try {
            $enrollment = $this->enrollmentService->enroll(auth()->user(), $offering);
            return redirect()->route('enrollments.index')
                ->with('success', 'Successfully enrolled! Start: ' . $enrollment->start_date->format('d M Y'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function adminIndex(Request $request)
    {
        $query = \App\Models\UserCourseEnrollment::with([
            'user', 'courseOffering.course', 'priceSource'
        ]);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%$s%")
                ->orWhere('email', 'like', "%$s%"));
        }

        $enrollments = $query->latest('enrolled_at')->paginate(15);
        return view('admin.enrollments.index', compact('enrollments'));
    }
}