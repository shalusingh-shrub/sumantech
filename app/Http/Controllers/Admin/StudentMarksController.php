<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentCourse;
use App\Models\StudentMark;
use Illuminate\Http\Request;

class StudentMarksController extends Controller
{
    private $courseSubjects = [
        'DCA' => ['Computer Fundamentals', 'MS Word', 'MS Excel', 'MS PowerPoint', 'Internet & Email', 'Typing'],
        'ADCA' => ['Computer Fundamentals', 'MS Office', 'Tally Prime', 'Internet', 'HTML Basics', 'Typing', 'Project Work'],
        'Advanced Diploma in Computer Application' => ['Computer Fundamentals', 'MS Office', 'Tally Prime', 'Internet', 'HTML & CSS', 'Typing', 'Project Work'],
        'Tally Prime' => ['Tally Fundamentals', 'GST in Tally', 'Accounting', 'Inventory', 'Payroll'],
        'DIGITA' => ['GST Fundamentals', 'Income Tax', 'Tally Prime', 'Accounting', 'E-Filing'],
        'HTML - Web Development' => ['HTML', 'CSS', 'JavaScript', 'Responsive Design', 'Project'],
        'Digital Marketing' => ['SEO', 'Social Media Marketing', 'Google Ads', 'Email Marketing', 'Analytics'],
        'MS Office' => ['MS Word', 'MS Excel', 'MS PowerPoint', 'MS Access', 'Typing'],
        'DTP (Desktop Publishing)' => ['CorelDraw', 'Photoshop', 'PageMaker', 'Printing Basics'],
        'Programming (C/C++/Python)' => ['C Programming', 'C++ Programming', 'Python Basics', 'Data Structures', 'Project'],
    ];

    public function index(Student $student, StudentCourse $studentCourse)
    {
        $marks = \App\Models\StudentMark::where('student_course_id', $studentCourse->id)->get();
        $subjects = $this->courseSubjects[$studentCourse->course_name] ?? ['Subject 1', 'Subject 2', 'Subject 3'];
        return view('admin.marks.index', compact('student', 'studentCourse', 'subjects', 'marks'));
    }

    public function store(Request $request, Student $student, StudentCourse $studentCourse)
    {
        $request->validate([
            'subjects'   => 'required|array',
            'max_marks'  => 'required|array',
            'obtained'   => 'required|array',
        ]);

        // Delete old marks
        $studentCourse->marks()->delete();

        // Save new marks
        foreach ($request->subjects as $i => $subject) {
            if ($subject) {
                StudentMark::create([
                    'student_course_id' => $studentCourse->id,
                    'subject_name'      => $subject,
                    'max_marks'         => $request->max_marks[$i] ?? 100,
                    'obtained_marks'    => $request->obtained[$i] ?? 0,
                ]);
            }
        }

        // Update total marks in student_courses
        $freshMarks = \App\Models\StudentMark::where('student_course_id', $studentCourse->id)->get();
        $total = $freshMarks->sum('max_marks');
        $obtained = $freshMarks->sum('obtained_marks');
        $percentage = $total > 0 ? round(($obtained / $total) * 100, 2) : 0;
        $studentCourse->update(['marks' => $percentage . '%']);

        return redirect()->route('admin.registration.show', $student)->with('success', 'Marks save ho gaye!');
    }
}