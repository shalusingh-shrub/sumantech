<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
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
            'user_type' => 'required|in:teacher,student,other',
            'district'  => 'nullable|string|max:100',
            'school'    => 'nullable|string|max:255',
            'password'  => 'required|min:8|confirmed',
        ], [
            'name.required'      => 'Naam zaroori hai.',
            'email.required'     => 'Email zaroori hai.',
            'email.unique'       => 'Yeh email already registered hai.',
            'phone.required'     => 'Phone number zaroori hai.',
            'user_type.required' => 'Account type select karo.',
            'password.required'  => 'Password zaroori hai.',
            'password.min'       => 'Password kam se kam 8 characters ka hona chahiye.',
            'password.confirmed' => 'Password match nahi kar raha.',
        ]);

        $user = User::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'user_type'        => $request->user_type,
            'district'         => $request->district,
            'school'           => $request->school,
            'password'         => Hash::make($request->password),
            'is_active'        => true,
            'can_access_admin' => false, // admin access nahi hoga by default
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
        return redirect()->route('portal.overview')->with('success', 'Welcome to Teachers of Bihar! Please complete your profile.');
    }
}
