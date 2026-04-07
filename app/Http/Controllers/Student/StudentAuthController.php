<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentAuthController extends Controller
{
    public function loginForm()
    {
        if (session('student_id')) {
            return redirect()->route('student.dashboard');
        }
        return view('student.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required',
            'password' => 'required',
        ]);

        $student = Student::where('registration_number', $request->login)
                          ->orWhere('mobile', $request->login)
                          ->orWhere('email', $request->login)
                          ->first();

        if (!$student) {
            return back()->withErrors(['login' => 'ID, Mobile ya Email galat hai!']);
        }

        if ($student->password !== $request->password) {
            return back()->withErrors(['password' => 'Password galat hai!']);
        }

        if ($student->status !== 'active') {
            return back()->withErrors(['login' => 'Account active nahi hai!']);
        }

        session(['student_id' => $student->id]);
        return redirect()->route('student.dashboard');
    }

    public function logout()
    {
        session()->forget('student_id');
        return redirect()->route('student.login');
    }
}