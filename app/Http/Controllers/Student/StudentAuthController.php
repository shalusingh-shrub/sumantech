<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $student = User::where('role', 'student')
            ->where(function ($query) use ($request) {
                $query->where('email', $request->login)
                    ->orWhereHas('profile', function ($profile) use ($request) {
                        $profile->where('registration_number', $request->login)
                            ->orWhere('mobile', $request->login);
                    });
            })
            ->with('profile')
            ->first();

        if (!$student) {
            return back()->withErrors(['login' => 'ID, Mobile ya Email galat hai!']);
        }

        if (!Hash::check($request->password, $student->password)) {
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
