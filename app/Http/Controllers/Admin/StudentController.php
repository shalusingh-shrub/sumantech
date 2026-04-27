<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = User::where('role', 'student')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('registration_number', 'like', '%' . $request->search . '%')
                  ->orWhere('mobile', 'like', '%' . $request->search . '%');
            })->latest()->paginate(10);

        return view('admin.registered_users.index', compact('students'));
    }

    public function create()
    {
        $reg_number = User::generateRegNumber();
        return view('admin.registered_users.create', compact('reg_number'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'father_name'   => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'mobile'        => 'required|digits:10|unique:users,mobile',
            'address'       => 'required|string',
            'gender'        => 'required|in:male,female,other',
            'password'      => 'required|min:6',
            'status'        => 'required|in:active,inactive',
        ]);

        $email = $request->email ?: ('student_' . time() . '@sumantech.local');

        $data = $request->except(['image', 'aadhaar_card']);
        $data['email']               = $email;
        $data['role']                = 'student';
        $data['registration_number'] = User::generateRegNumber();
        $data['registration_date']   = $request->registration_date ?? now()->toDateString();
        $data['password']            = Hash::make($request->password);
        $data['is_active']           = true;
        $data['phone']               = $request->mobile;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('students/photos', 'public');
        }
        if ($request->hasFile('aadhaar_card')) {
            $data['aadhaar_card'] = $request->file('aadhaar_card')->store('students/aadhaar', 'public');
        }

        User::create($data);
        return redirect()->route('admin.students.index')->with('success', 'Student registered successfully!');
    }

    public function show(User $student)
    {
        $student->load('courses.course');
        return view('admin.registered_users.show', compact('student'));
    }

    public function edit(User $student)
    {
        return view('admin.registered_users.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $data = $request->except(['password', 'image', 'aadhaar_card', '_token', '_method']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            if ($student->image) Storage::disk('public')->delete($student->image);
            $data['image'] = $request->file('image')->store('students/photos', 'public');
        }
        if ($request->hasFile('aadhaar_card')) {
            if ($student->aadhaar_card) Storage::disk('public')->delete($student->aadhaar_card);
            $data['aadhaar_card'] = $request->file('aadhaar_card')->store('students/aadhaar', 'public');
        }

        $student->update($data);
        return redirect()->route('admin.students.show', $student)->with('success', 'Student updated successfully!');
    }

    public function destroy(User $student)
    {
        if ($student->image) Storage::disk('public')->delete($student->image);
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted.');
    }

    public function toggleStatus(User $student)
    {
        $student->update([
            'status'    => $student->status === 'active' ? 'inactive' : 'active',
            'is_active' => $student->status === 'active' ? false : true,
        ]);
        return redirect()->back()->with('success', 'Status updated!');
    }

    public function addCourse(Request $request, User $student)
    {
        $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
            'reg_date'   => 'required|date',
            'status'     => 'required|in:Active,Inactive',
        ]);

        $course = Course::find($request->course_id);

        StudentCourse::create([
            'user_id'    => $student->id,
            'course_id'  => $request->course_id,
            'course_name'=> $course->name,
            'amount'     => $course->fee,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'reg_date'   => $request->reg_date,
            'status'     => $request->status,
            'cert_status'=> 'Pending',
        ]);

        return redirect()->route('admin.students.show', $student)->with('success', 'Course added successfully!');
    }

    public function certificate(User $student, StudentCourse $studentCourse)
    {
        return view('admin.students.certificate', compact('student', 'studentCourse'));
    }

    public function updateCertificate(Request $request, StudentCourse $studentCourse)
    {
        $data = $request->except(['_token', '_method', 'certificate_image']);

        if ($request->hasFile('certificate_image')) {
            $data['certificate_image'] = $request->file('certificate_image')->store('certificates', 'public');
        }

        if ($request->regenerate_certificate === 'yes') {
            do {
                $id = 'ST-' . random_int(1000000000, 9999999999);
            } while (StudentCourse::where('certificate_id', $id)->exists());
            $data['certificate_id'] = $id;
        }

        $studentCourse->update($data);
        return redirect()->back()->with('success', 'Certificate updated successfully!');
    }
}