<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseCategoryController extends Controller
{
    public function index(Course $course)
    {
        $categories = $course->categories()->get();
        return view('admin.courses.categories.index', compact('course', 'categories'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'program_name' => 'nullable|string|max:255',
            'duration'     => 'nullable|string|max:100',
            'fee'          => 'nullable|numeric|min:0',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['course_id'] = $course->id;
        $data['slug']      = Str::slug($request->name);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order']= $course->categories()->count() + 1;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('course-categories', 'public');
        }

        CourseCategory::create($data);
        return redirect()->route('admin.courses.categories.index', $course)
                         ->with('success', 'Sub Course added!');
    }

    public function edit(Course $course, CourseCategory $category)
    {
        return view('admin.courses.categories.edit', compact('course', 'category'));
    }

    public function update(Request $request, Course $course, CourseCategory $category)
    {
        $data = $request->except('image');
        $data['slug']      = Str::slug($request->name);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($category->image) Storage::disk('public')->delete($category->image);
            $data['image'] = $request->file('image')->store('course-categories', 'public');
        }

        $category->update($data);
        return redirect()->route('admin.courses.categories.index', $course)
                         ->with('success', 'Sub Course updated!');
    }

    public function destroy(Course $course, CourseCategory $category)
    {
        if ($category->image) Storage::disk('public')->delete($category->image);
        $category->delete();
        return redirect()->route('admin.courses.categories.index', $course)
                         ->with('success', 'Sub Course deleted!');
    }
}