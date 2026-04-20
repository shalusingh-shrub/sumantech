<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentCourse;
use App\Models\StudentMark;
use App\Models\CourseMarksTemplate;
use Illuminate\Http\Request;

class StudentMarksController extends Controller
{
    public function index(Student $student, StudentCourse $studentCourse)
    {
        $marks    = $studentCourse->studentMarks()->get();
        $template = CourseMarksTemplate::where('course_name', $studentCourse->course_name)->first();

        if ($template) {
            if (is_string($template->subjects)) {
                $template->subjects = json_decode($template->subjects, true) ?? [];
            }
            if (is_string($template->grade_standards)) {
                $template->grade_standards = json_decode($template->grade_standards, true) ?? [];
            }
        }

        return view('admin.marks.index', compact('student', 'studentCourse', 'marks', 'template'));
    }

    public function store(Request $request, Student $student, StudentCourse $studentCourse)
    {
        $request->validate([
            'subjects'  => 'required|array',
            'max_marks' => 'required|array',
            'obtained'  => 'required|array',
        ]);

        $studentCourse->studentMarks()->delete();

        $template      = CourseMarksTemplate::where('course_name', $studentCourse->course_name)->first();
        $totalMax      = 0;
        $totalObtained = 0;

        foreach ($request->subjects as $i => $subject) {
            if (!$subject) continue;
            $max      = (int)($request->max_marks[$i] ?? 0);
            $obtained = (int)($request->obtained[$i] ?? 0);
            $totalMax      += $max;
            $totalObtained += $obtained;
            $pct    = $max > 0 ? round(($obtained / $max) * 100, 1) : 0;
            $grade  = 'N/A';
            $result = 'N/A';

            if ($template) {
                $gradeInfo = $template->calculateGrade($pct);
                $grade     = $gradeInfo['grade'];
                $result    = $gradeInfo['result'];
            }

            StudentMark::create([
                'student_course_id' => $studentCourse->id,
                'subject_name'      => $subject,
                'max_marks'         => $max,
                'obtained_marks'    => $obtained,
                'percentage'        => $pct,
                'grade'             => $grade,
                'result'            => $result,
                'notes'             => $request->notes ?? null,
            ]);
        }

        // Completion date update
        if ($request->filled('completion_date')) {
            $studentCourse->update(['end_date' => $request->completion_date]);
        }

        // Overall grade
        $overallPct = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 1) : 0;
        $studentCourse->update([
            'overall_percentage' => $overallPct,
        ]);

        return redirect()->route('admin.marks.index', [$student, $studentCourse])
                         ->with('success', 'Marks saved! Overall: ' . $overallPct . '%');
    }
}