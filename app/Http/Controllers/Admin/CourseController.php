<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::latest();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
        $courses = $query->paginate($request->get('per_page', 10))->withQueryString();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:courses,slug',
            'duration'    => 'required|string|max:100',
            'fee'         => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'highlights'  => 'nullable|string',
        ]);

        $data = $request->except('image');
        $data['slug'] = $request->slug ?: Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        Course::create($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course added!');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:courses,slug,' . $course->id,
            'duration'    => 'required|string|max:100',
            'fee'         => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'highlights'  => 'nullable|string',
        ]);

        $data = $request->except('image');
        $data['slug'] = $request->slug ?: Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($course->image) Storage::disk('public')->delete($course->image);
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course updated!');
    }

    public function destroy(Course $course)
    {
        if ($course->image) Storage::disk('public')->delete($course->image);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted.');
    }

    public function getDetails(Course $course)
    {
        return response()->json($course);
    }
}