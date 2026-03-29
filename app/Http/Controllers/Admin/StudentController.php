<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // List all students
    public function index(Request $request)
    {
        $students = Student::when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('registration_number', 'like', '%' . $request->search . '%')
              ->orWhere('mobile', 'like', '%' . $request->search . '%');
        })->latest()->paginate(10);

        return view('admin.registered_users.index', compact('students'));
    }

    // Show add form
    public function create()
    {
        $reg_number = Student::generateRegNumber();
        return view('admin.registered_users.create', compact('reg_number'));
    }

    // Store new student
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'father_name'   => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'mobile'        => 'required|digits:10|unique:students,mobile',
            'address'       => 'required|string',
            'gender'        => 'required|in:male,female,other',
            'password'      => 'required|min:6',
            'status'        => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $data['registration_number'] = Student::generateRegNumber();
        $data['registration_date']   = $request->registration_date ?? now()->toDateString();
        $data['password']            = Hash::make($request->password);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('students/photos', 'public');
        }
        if ($request->hasFile('aadhaar_card')) {
            $data['aadhaar_card'] = $request->file('aadhaar_card')->store('students/aadhaar', 'public');
        }

        Student::create($data);
        return redirect()->route('admin.students.index')->with('success', 'Student registered successfully!');
    }

    // Show student detail
    public function show(Student $student)
    {
        $student->load('courses.course');
        return view('admin.registered_users.show', compact('student'));
    }

    // Edit form
    public function edit(Student $student)
    {
        return view('admin.registered_users.edit', compact('student'));
    }

    // Update student
    public function update(Request $request, Student $student)
    {
        $data = $request->except(['password', 'image', 'aadhaar_card', '_token', '_method']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('students/photos', 'public');
        }
        if ($request->hasFile('aadhaar_card')) {
            $data['aadhaar_card'] = $request->file('aadhaar_card')->store('students/aadhaar', 'public');
        }

        $student->update($data);
        return redirect()->route('admin.students.show', $student)->with('success', 'Student updated successfully!');
    }

    // Delete student
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted.');
    }

    // Toggle status
    public function toggleStatus(Student $student)
    {
        $student->update(['status' => $student->status === 'active' ? 'inactive' : 'active']);
        return redirect()->back()->with('success', 'Status updated!');
    }

    // Add course to student
    public function addCourse(Request $request, Student $student)
    {
        $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
            'reg_date'   => 'required|date',
            'status'     => 'required|in:active,inactive',
        ]);

        $course = Course::find($request->course_id);

        $data = $request->all();
        $data['student_id']     = $student->id;
        $data['amount']         = $course->fee;
        $data['certificate_id'] = StudentCourse::generateCertificateId();

        StudentCourse::create($data);
        return redirect()->route('admin.students.show', $student)->with('success', 'Course added successfully!');
    }

    // Update certificate details
    public function updateCertificate(Request $request, StudentCourse $studentCourse)
    {
        $data = $request->except(['_token', '_method', 'certificate_image']);

        if ($request->hasFile('certificate_image')) {
            $data['certificate_image'] = $request->file('certificate_image')->store('certificates', 'public');
        }

        if ($request->regenerate_certificate === 'yes') {
            $data['certificate_id'] = StudentCourse::generateCertificateId();
        }

        $studentCourse->update($data);
        return redirect()->back()->with('success', 'Certificate updated successfully!');
    }
}
