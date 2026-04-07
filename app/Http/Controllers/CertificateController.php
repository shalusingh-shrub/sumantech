<?php
namespace App\Http\Controllers;

use App\Models\StudentCourse;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'certificate_id' => 'required|string',
        ]);

        $cert = StudentCourse::with('student')
            ->where('certificate_id', $request->certificate_id)
            ->where('cert_status', 'Active')
            ->first();

        if (!$cert) {
            return back()->withErrors(['certificate_id' => 'Certificate ID galat hai ya exist nahi karta!'])->withInput();
        }

        return back()->with('cert', $cert)->withInput();
    }
}