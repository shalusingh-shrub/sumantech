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
            'name'        => 'required|string|max:255|unique:courses,name',
            'slug'        => 'nullable|string|unique:courses,slug',
            'duration'    => 'required|string|max:100',
            'fee'         => 'required|numeric|min:0|max:999999',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string|max:5000',
            'highlights'  => 'nullable|string|max:3000',
            'course_level'=> 'nullable|in:beginner,intermediate,advanced',
            'eligibility' => 'nullable|string|max:500',
        ], [
            'name.required'  => 'course name zaroori hai!',
            'name.unique'    => 'ye course already exist karta hai!',
            'duration.required' => 'duration zaroori hai!',
            'fee.required'   => 'fee zaroori hai!',
            'fee.numeric'    => 'fee sirf number mein honi chahiye!',
            'fee.min'        => 'fee 0 se kam nahi ho sakti!',
            'image.mimes'    => 'image sirf jpg, png, webp format mein honi chahiye!',
            'image.max'      => 'image 2mb se zyada nahi honi chahiye!',
        ]);

        $data = $request->except(['image', 'syllabus']);
        $data['slug'] = $request->slug ?: Str::slug($request->name);

        if ($request->has('syllabus')) {
            $syllabus = [];
            foreach ($request->syllabus as $section) {
                if (!empty($section['section'])) {
                    $syllabus[] = [
                        'section' => $section['section'],
                        'topics'  => array_values(array_filter($section['topics'] ?? [])),
                    ];
                }
            }
            $data['syllabus'] = json_encode($syllabus);
        }

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
            'name'        => 'required|string|max:255|unique:courses,name,'.$course->id,
            'slug'        => 'nullable|string|unique:courses,slug,'.$course->id,
            'duration'    => 'required|string|max:100',
            'fee'         => 'required|numeric|min:0|max:999999',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string|max:5000',
            'highlights'  => 'nullable|string|max:3000',
            'course_level'=> 'nullable|in:beginner,intermediate,advanced',
            'eligibility' => 'nullable|string|max:500',
        ], [
            'name.required'  => 'course name zaroori hai!',
            'name.unique'    => 'ye course already exist karta hai!',
            'duration.required' => 'duration zaroori hai!',
            'fee.required'   => 'fee zaroori hai!',
            'fee.numeric'    => 'fee sirf number mein honi chahiye!',
            'image.mimes'    => 'image sirf jpg, png, webp format mein honi chahiye!',
            'image.max'      => 'image 2mb se zyada nahi honi chahiye!',
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