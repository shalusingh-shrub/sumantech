<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index() {
        $teachers = Teacher::orderBy('sort_order')->paginate(20);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create() {
        return view('admin.teachers.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order'  => 'nullable|integer',
            'status'      => 'required|in:Active,Inactive',
        ]);

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('teachers', 'public');
        }

        Teacher::create($data);
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher add ho gaya!');
    }

    public function edit(Teacher $teacher) {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher) {
        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order'  => 'nullable|integer',
            'status'      => 'required|in:Active,Inactive',
        ]);

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('teachers', 'public');
        }

        $teacher->update($data);
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher update ho gaya!');
    }

    public function destroy(Teacher $teacher) {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher delete ho gaya!');
    }
}