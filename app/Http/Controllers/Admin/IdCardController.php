<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class IdCardController extends Controller
{
    public function show(Student $student)
    {
        $student->load('courses');
        return view('admin.idcard.show', compact('student'));
    }

    public function downloadPdf(Student $student)
    {
        $student->load('courses');
        $pdf = Pdf::loadView('admin.idcard.pdf', compact('student'))
            ->setPaper([0, 0, 283.46, 425.2], 'portrait'); // 10x15 cm
        return $pdf->download('ID-Card-' . $student->registration_number . '.pdf');
    }
}