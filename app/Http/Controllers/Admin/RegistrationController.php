<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $query = Student::query();
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
        $total    = Student::count();
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
            'registration_number' => 'nullable|unique:students,registration_number',
        ]);

        if ($request->filled('registration_number')) {
            $regNum = $request->registration_number;
        } else {
            do {
                $regNum = 'ST-' . random_int(1000000000, 9999999999);
            } while (Student::where('registration_number', $regNum)->exists());
        }

        $data = [
            'registration_number' => $regNum,
            'registration_date'   => $request->registration_date ?? now()->toDateString(),
            'name'                => $request->name,
            'father_name'         => $request->father_name,
            'date_of_birth'       => $request->date_of_birth,
            'email'               => $request->email,
            'mobile'              => $request->mobile,
            'whatsapp'            => $request->whatsapp,
            'address'             => $request->address,
            'aadhaar_number'      => $request->aadhaar_number,
            'gender'              => strtolower($request->gender),
            'password'            => $request->password,
            'status'              => strtolower($request->status ?? 'active'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('students', 'public');
        }
        if ($request->hasFile('aadhaar_card')) {
            $data['aadhaar_card'] = basename($request->file('aadhaar_card')->store('students/aadhaar', 'public'));
        }

        Student::create($data);
        return redirect()->route('admin.registration.index')->with('success', 'Student registered successfully!');
    }

    public function show(Student $student)
    {
        $student->load('courses');
        return view('admin.registration.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('admin.registration.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
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
            'email'             => $request->email,
            'mobile'            => $request->mobile,
            'whatsapp'          => $request->whatsapp,
            'address'           => $request->address,
            'aadhaar_number'    => $request->aadhaar_number,
            'gender'            => strtolower($request->gender),
            'status'            => strtolower($request->status ?? 'active'),
        ];

        if ($request->hasFile('image')) {
            if ($student->image) Storage::disk('public')->delete('students/' . $student->image);
            $data['image'] = $request->file('image')->store('students', 'public');
        }
        if ($request->hasFile('aadhaar_card')) {
            if ($student->aadhaar_card) Storage::disk('public')->delete('students/aadhaar/' . $student->aadhaar_card);
            $data['aadhaar_card'] = $request->file('aadhaar_card')->store('students/aadhaar', 'public');
        }

        $student->update($data);
        return redirect()->route('admin.registration.show', $student)->with('success', 'Student updated!');
    }

    public function destroy(Student $student)
    {
        if ($student->image) Storage::disk('public')->delete('students/' . $student->image);
        $student->delete();
        return redirect()->route('admin.registration.index')->with('success', 'Student deleted!');
    }

    public function addCourseForm(Student $student)
    {
        $courses = $this->courseList;
        $student->load('courses');
        return view('admin.registration.add_course', compact('student', 'courses'));
    }

    public function storeCourse(Request $request, Student $student)
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

        return redirect()->route('admin.invoices.index', $student)->with('success', 'Course added! Ab invoice banao.');
    }

    public function editCourse(Student $student, StudentCourse $course)
    {
        $courses = $this->courseList;
        return view('admin.registration.edit_course', compact('student', 'course', 'courses'));
    }

    public function updateCourse(Request $request, Student $student, StudentCourse $course)
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

    public function certificateBuilder(Student $student, StudentCourse $course)
    {
        return view('admin.registration.certificate_builder', compact('student', 'course'));
    }
}