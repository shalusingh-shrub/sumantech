<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMarksTemplate;
use Illuminate\Http\Request;

class CourseMarksTemplateController extends Controller
{
    public function index()
    {
        $templates = CourseMarksTemplate::with('course')->latest()->get();
        $courses   = Course::where('is_active', true)->get();
        return view('admin.marks.templates.index', compact('templates', 'courses'));
    }

    public function create()
    {
        $courses = Course::where('is_active', true)->get();
        return view('admin.marks.templates.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_name'    => 'required|string',
            'subjects'       => 'required|array|min:1',
            'subjects.*.name'=> 'required|string',
            'subjects.*.max' => 'required|integer|min:1',
        ]);

        $subjects = [];
        foreach ($request->subjects as $s) {
            if (!empty($s['name'])) {
                $subjects[] = [
                    'name'      => $s['name'],
                    'max_marks' => (int)$s['max'],
                ];
            }
        }

        $gradeStandards = [];
        if ($request->has('grades')) {
            foreach ($request->grades as $g) {
                if (!empty($g['grade'])) {
                    $gradeStandards[] = [
                        'grade'  => $g['grade'],
                        'min'    => (int)$g['min'],
                        'max'    => (int)$g['max'],
                        'result' => $g['result'],
                    ];
                }
            }
        }

        CourseMarksTemplate::create([
            'course_id'       => $request->course_id ?: null,
            'course_name'     => $request->course_name,
            'subjects'        => json_encode($subjects),
            'grade_standards' => json_encode($gradeStandards),
            'notes'           => $request->notes,
        ]);

        return redirect()->route('admin.marks.templates.index')
                         ->with('success', 'Marks template created!');
    }

    public function edit(CourseMarksTemplate $template)
    {
        $courses = Course::where('is_active', true)->get();
        return view('admin.marks.templates.edit', compact('template', 'courses'));
    }

    public function update(Request $request, CourseMarksTemplate $template)
    {
        $subjects = [];
        foreach ($request->subjects as $s) {
            if (!empty($s['name'])) {
                $subjects[] = [
                    'name'      => $s['name'],
                    'max_marks' => (int)$s['max'],
                ];
            }
        }

        $gradeStandards = [];
        if ($request->has('grades')) {
            foreach ($request->grades as $g) {
                if (!empty($g['grade'])) {
                    $gradeStandards[] = [
                        'grade'  => $g['grade'],
                        'min'    => (int)$g['min'],
                        'max'    => (int)$g['max'],
                        'result' => $g['result'],
                    ];
                }
            }
        }

        $template->update([
            'course_id'       => $request->course_id ?: null,
            'course_name'     => $request->course_name,
            'subjects'        => json_encode($subjects),
            'grade_standards' => json_encode($gradeStandards),
            'notes'           => $request->notes,
        ]);

        return redirect()->route('admin.marks.templates.index')
                         ->with('success', 'Template updated!');
    }

    public function destroy(CourseMarksTemplate $template)
    {
        $template->delete();
        return redirect()->route('admin.marks.templates.index')
                         ->with('success', 'Template deleted!');
    }
}