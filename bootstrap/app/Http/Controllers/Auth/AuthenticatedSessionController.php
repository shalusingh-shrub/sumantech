<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create() {
        return view('auth.login');
    }

    public function store(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'captcha'  => 'required',
        ], [
            'captcha.required' => 'CAPTCHA fill karna zaroori hai.',
        ]);

        // Case-insensitive CAPTCHA check
        $sessionCaptcha = session('captcha', '');
        $inputCaptcha   = strtolower(trim($request->captcha));

        if (empty($sessionCaptcha) || $inputCaptcha !== $sessionCaptcha) {
            return back()
                ->withErrors(['captcha' => 'CAPTCHA galat hai. Dobara try karein.'])
                ->withInput($request->except('password', 'captcha'));
        }

        // Clear captcha from session after use
        session()->forget('captcha');

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = auth()->user();

            // Log login activity
            try {
                UserActivity::create([
                    'user_id'     => $user->id,
                    'description' => 'User logged in',
                    'event'       => 'login',
                    'subject'     => 'User #'.$user->id,
                ]);
            } catch (\Exception $e) {}

            // Admin/Editor -> Admin Panel
            if ($user->hasAnyRole(['super_admin', 'admin', 'editor']) || $user->can_access_admin) {
                return redirect()->route('admin.dashboard');
            }

            // Regular users -> Portal
            return redirect()->route('portal.overview');
        }

        return back()
            ->withErrors(['email' => 'Email ya password galat hai.'])
            ->withInput($request->except('password', 'captcha'));
    }

    public function destroy(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
