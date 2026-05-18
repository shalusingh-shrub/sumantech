<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create() {
        return view('auth.register');
    }

    public function store(Request $request) {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|string|max:15',
            'date_of_birth' => 'required|date|before:today',
            'user_type' => 'required|in:teacher,student,other',
            'district'  => 'nullable|string|max:100',
            'school'    => 'nullable|string|max:255',
            'password'  => 'required|min:8|confirmed',
        ], [
            'name.required'      => 'Name is required.',
            'email.required'     => 'Email is required.',
            'email.unique'       => 'Yeh email already registered hai.',
            'phone.required'     => 'Phone number is required.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before'   => 'Date of birth must be before today.',
            'user_type.required' => 'Please select an account type.',
            'password.required'  => 'Password is required.',
            'password.min'       => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user = User::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'user_type'        => $request->user_type,
            'role'             => in_array($request->user_type, ['teacher', 'student']) ? $request->user_type : 'student',
            'password'         => Hash::make($request->password),
            'is_active'        => false,
            'can_access_admin' => false, // admin access is disabled by default
        ]);
    $regNum = User::generateRegNumber($request->date_of_birth);
        UserProfile::create([
            'user_id' => $user->id,
            'registration_number' => $regNum,
            'dob' => $request->date_of_birth,
            'mobile' => $request->phone,
            'district' => $request->district,
            'school' => $request->school,
            'class' => $request->class,
            'status' => 'active',
        ]);

        Auth::login($user);

        // Log activity
        UserActivity::create([
            'user_id'     => $user->id,
            'description' => 'Account created successfully',
            'event'       => 'registered',
            'subject'     => 'User #'.$user->id,
        ]);

        // Redirect to PORTAL - not admin!
        return redirect()->route('portal.overview')->with('success', "Welcome $request->name! Please complete your profile.");
    }
}
