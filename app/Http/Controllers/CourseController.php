<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::query()
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('frontend.courses', compact('courses'));
    }

    public function show(Course $course)
    {
        abort_unless($course->is_active, 404);

        return view('frontend.course_show', compact('course'));
    }

    public function legacyShow(int $id)
    {
        $course = Course::where('is_active', true)->findOrFail($id);

        return redirect()->route('course.show', $course->slug);
    }
}
