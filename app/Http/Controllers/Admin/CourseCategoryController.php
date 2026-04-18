<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::orderBy('sort_order')->get();
        return view('admin.course_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.course_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:course_categories,slug',
            'description' => 'nullable|string',
            'color'       => 'nullable|string',
            'icon'        => 'nullable|string',
            'sort_order'  => 'nullable|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = $request->slug ?: Str::slug($request->name);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('course-categories', 'public');
        }

        CourseCategory::create($data);
        return redirect()->route('admin.course-categories.index')
                         ->with('success', 'Category created!');
    }

    public function edit(CourseCategory $courseCategory)
    {
        return view('admin.course_categories.edit', compact('courseCategory'));
    }

    public function update(Request $request, CourseCategory $courseCategory)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'nullable|string|unique:course_categories,slug,' . $courseCategory->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = $request->slug ?: Str::slug($request->name);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('course-categories', 'public');
        }

        $courseCategory->update($data);
        return redirect()->route('admin.course-categories.index')
                         ->with('success', 'Category updated!');
    }

    public function destroy(CourseCategory $courseCategory)
    {
        $courseCategory->delete();
        return redirect()->route('admin.course-categories.index')
                         ->with('success', 'Category deleted!');
    }
}