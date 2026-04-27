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
            ->with('profile')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('profile', function ($profile) use ($request) {
                      $profile->where('registration_number', 'like', '%' . $request->search . '%')
                          ->orWhere('mobile', 'like', '%' . $request->search . '%');
                  });
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
            'mobile'        => 'required|digits:10|unique:user_profiles,mobile',
            'address'       => 'required|string',
            'gender'        => 'required|in:male,female,other',
            'password'      => 'required|min:6',
            'status'        => 'required|in:active,inactive',
        ]);

        $email = $request->email ?: ('student_' . time() . '@sumantech.local');

        $userData = [
            'name' => $request->name,
            'email' => $email,
            'role' => 'student',
            'user_type' => 'student',
            'password' => Hash::make($request->password),
            'is_active' => $request->status === 'active',
            'phone' => $request->mobile,
        ];

        $profileData = $request->only([
            'father_name', 'date_of_birth', 'mobile', 'whatsapp', 'address',
            'aadhaar_number', 'gender', 'status',
        ]);
        $profileData['dob'] = $request->date_of_birth;
        unset($profileData['date_of_birth']);
        $profileData['registration_number'] = User::generateRegNumber($request->date_of_birth);
        $profileData['registration_date'] = $request->registration_date ?? now()->toDateString();

        if ($request->hasFile('image')) {
            $profileData['image'] = $request->file('image')->store('students/photos', 'public');
        }
        if ($request->hasFile('aadhaar_card')) {
            $profileData['aadhaar_card'] = $request->file('aadhaar_card')->store('students/aadhaar', 'public');
        }

        $student = User::create($userData);
        $student->profile()->create($profileData);
        return redirect()->route('admin.students.index')->with('success', 'Student registered successfully!');
    }

    public function show(User $student)
    {
        $student->load('profile', 'courses.course');
        return view('admin.registered_users.show', compact('student'));
    }

    public function edit(User $student)
    {
        $student->load('profile');
        return view('admin.registered_users.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $userData = [
            'name' => $request->name,
            'email' => $request->email ?: $student->email,
            'phone' => $request->mobile,
            'is_active' => ($request->status ?? $student->status) === 'active',
        ];

        $profileData = $request->only([
            'father_name', 'mobile', 'whatsapp', 'address',
            'aadhaar_number', 'gender', 'status',
        ]);
        $profileData['dob'] = $request->date_of_birth;
        $profileData['registration_date'] = $request->registration_date;

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            if ($student->image) Storage::disk('public')->delete($student->image);
            $profileData['image'] = $request->file('image')->store('students/photos', 'public');
        }
        if ($request->hasFile('aadhaar_card')) {
            if ($student->aadhaar_card) Storage::disk('public')->delete($student->aadhaar_card);
            $profileData['aadhaar_card'] = $request->file('aadhaar_card')->store('students/aadhaar', 'public');
        }

        $student->update($userData);
        $student->profile()->updateOrCreate(['user_id' => $student->id], $profileData);
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
            'is_active' => $student->status === 'active' ? false : true,
        ]);
        $student->profile()->updateOrCreate(
            ['user_id' => $student->id],
            ['status' => $student->status === 'active' ? 'inactive' : 'active']
        );
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

    public function certificate(StudentCourse $studentCourse)
    {
        $student = $studentCourse->student()->with('profile')->firstOrFail();
        return view('admin.registered_users.certificate', compact('student', 'studentCourse'));
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
