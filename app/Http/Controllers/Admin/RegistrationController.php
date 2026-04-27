<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    private array $courseList = [
        'DCA'                                      => ['duration' => '2 MONTH', 'fee' => 3999],
        'ADCA'                                     => ['duration' => '4 MONTH', 'fee' => 5999],
        'Advanced Diploma in Computer Application' => ['duration' => '6 MONTH', 'fee' => 7999],
        'Tally Prime'                              => ['duration' => '2 MONTH', 'fee' => 3499],
        'DIGITA'                                   => ['duration' => '6 MONTH', 'fee' => 8999],
        'HTML - Web Development'                   => ['duration' => '2 MONTH', 'fee' => 3999],
        'Digital Marketing'                        => ['duration' => '3 MONTH', 'fee' => 4999],
        'MS Office'                                => ['duration' => '1 MONTH', 'fee' => 1499],
        'DTP (Desktop Publishing)'                 => ['duration' => '1 MONTH', 'fee' => 1999],
        'Programming (C/C++/Python)'               => ['duration' => '3 MONTH', 'fee' => 4999],
    ];

    public function index(Request $request)
    {
        $query = User::where('role', 'student');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name',                'like', "%$s%")
                  ->orWhere('registration_number','like', "%$s%")
                  ->orWhere('mobile',             'like', "%$s%")
                  ->orWhere('email',              'like', "%$s%")
                  ->orWhere('father_name',        'like', "%$s%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate($request->get('per_page', 10))->withQueryString();
        $total    = User::where('role', 'student')->count();

        return view('admin.registration.index', compact('students', 'total'));
    }

    public function create()
    {
        return view('admin.registration.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'father_name'   => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'mobile'        => 'required|digits:10',
            'address'       => 'required|string',
            'gender'        => 'required|in:male,female,other',
            'password'      => 'required|string|min:4',
            'registration_number' => 'nullable|unique:users,registration_number',
        ]);

        if ($request->filled('registration_number')) {
    $regNum = $request->registration_number;
} else {
    $regNum = User::generateRegNumber($request->date_of_birth);
}

        $email = $request->email ?: ('student_' . time() . '@sumantech.local');

        $data = [
            'name'                => $request->name,
            'email'               => $email,
            'password'            => Hash::make($request->password),
            'role'                => 'student',
            'registration_number' => $regNum,
            'registration_date'   => $request->registration_date ?? now()->toDateString(),
            'father_name'         => $request->father_name,
            'date_of_birth'       => $request->date_of_birth,
            'mobile'              => $request->mobile,
            'whatsapp'            => $request->whatsapp,
            'address'             => $request->address,
            'aadhaar_number'      => $request->aadhaar_number,
            'gender'              => strtolower($request->gender),
            'status'              => strtolower($request->status ?? 'active'),
            'is_active'           => true,
            'phone'               => $request->mobile,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('students', 'public');
        }
        if ($request->hasFile('aadhaar_card')) {
            $data['aadhaar_card'] = $request->file('aadhaar_card')->store('students/aadhaar', 'public');
        }

        $student = User::create($data);

        \App\Models\Notification::send(
            'new_student',
            'Naya Student Register!',
            $data['name'] . ' ne registration kiya — ' . $regNum,
            route('admin.registration.show', $student)
        );

        return redirect()->route('admin.registration.index')->with('success', 'Student registered successfully!');
    }

    public function show(User $student)
    {
        $student->load('courses');
        return view('admin.registration.show', compact('student'));
    }

    public function edit(User $student)
    {
        return view('admin.registration.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'father_name'   => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'mobile'        => 'required|digits:10',
            'address'       => 'required|string',
            'gender'        => 'required|in:male,female,other',
        ]);

        $data = [
            'registration_date' => $request->registration_date,
            'name'              => $request->name,
            'father_name'       => $request->father_name,
            'date_of_birth'     => $request->date_of_birth,
            'email'             => $request->email ?: $student->email,
            'mobile'            => $request->mobile,
            'phone'             => $request->mobile,
            'whatsapp'          => $request->whatsapp,
            'address'           => $request->address,
            'aadhaar_number'    => $request->aadhaar_number,
            'gender'            => strtolower($request->gender),
            'status'            => strtolower($request->status ?? 'active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            if ($student->image) Storage::disk('public')->delete($student->image);
            $data['image'] = $request->file('image')->store('students', 'public');
        }
        if ($request->hasFile('aadhaar_card')) {
            if ($student->aadhaar_card) Storage::disk('public')->delete($student->aadhaar_card);
            $data['aadhaar_card'] = $request->file('aadhaar_card')->store('students/aadhaar', 'public');
        }

        $student->update($data);
        return redirect()->route('admin.registration.show', $student)->with('success', 'Student updated!');
    }

    public function destroy(User $student)
    {
        if ($student->image) Storage::disk('public')->delete($student->image);
        $student->delete();
        return redirect()->route('admin.registration.index')->with('success', 'Student deleted!');
    }

    public function addCourseForm(User $student)
    {
        $courses = $this->courseList;
        $student->load('courses');
        return view('admin.registration.add_course', compact('student', 'courses'));
    }

    public function storeCourse(Request $request, User $student)
    {
        $request->validate([
            'course_name' => 'required|string',
            'reg_date'    => 'required|date',
            'status'      => 'required|in:Active,Inactive',
        ]);

        $selected = $this->courseList[$request->course_name] ?? [];

        $student->courses()->create([
            'course_name'     => $request->course_name,
            'course_duration' => $selected['duration'] ?? null,
            'amount'          => $selected['fee'] ?? null,
            'discount'        => $request->discount ?? 0,
            'start_date'      => $request->start_date ?: null,
            'end_date'        => $request->end_date ?: null,
            'reg_date'        => $request->reg_date,
            'status'          => $request->status,
            'cert_status'     => 'Pending',
        ]);

        return redirect()->route('admin.invoices.index', $student)->with('success', 'Course added!');
    }

    public function editCourse(User $student, StudentCourse $course)
    {
        $courses = $this->courseList;
        return view('admin.registration.edit_course', compact('student', 'course', 'courses'));
    }

    public function updateCourse(Request $request, User $student, StudentCourse $course)
    {
        $data = [
            'start_date'                 => $request->start_date ?: null,
            'end_date'                   => $request->end_date ?: null,
            'certificate_issue_date'     => $request->issue_date ?: null,
            'certificate_receiving_date' => $request->cert_receiving_date ?: null,
            'marks'                      => $request->marks,
            'tally_details'              => $request->tally_details,
            'status'                     => $request->status,
            'cert_status'                => $request->cert_status,
            'regenerate_certificate'     => $request->boolean('regenerate_cert'),
        ];

        $course->update($data);
        return redirect()->route('admin.registration.show', $student)->with('success', 'Course updated!');
    }

    public function certificateBuilder(User $student, StudentCourse $course)
    {
        return view('admin.registration.certificate_builder', compact('student', 'course'));
    }
}