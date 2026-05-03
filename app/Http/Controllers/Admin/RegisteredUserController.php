<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    public function index(Request $request) {
        $query = User::with('profile');
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
                  ->orWhere('phone', 'like', '%'.$request->search.'%')
                  ->orWhereHas('profile', function ($profile) use ($request) {
                      $profile->where('district', 'like', '%'.$request->search.'%')
                          ->orWhere('school', 'like', '%'.$request->search.'%');
                  });
            });
        }
        if ($request->user_type) $query->where('user_type', $request->user_type);
        if ($request->status !== null && $request->status !== '') $query->where('is_active', $request->status);

        $users = $query->latest()->paginate($request->get('per_page', 20))->withQueryString();
        $stats = [
            'total'    => User::count(),
            'teachers' => User::where('user_type', 'teacher')->count(),
            'students' => User::where('user_type', 'student')->count(),
            'active'   => User::where('is_active', true)->count(),
        ];
        return view('admin.registered_users.admin_index', compact('users', 'stats'));
    }

    public function toggleStatus(User $user) {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'User status updated!');
    }

    public function toggleAdminAccess(User $user) {
        $user->update(['can_access_admin' => !$user->can_access_admin]);
        $msg = $user->can_access_admin ? 'Admin access diya gaya!' : 'Admin access hataya gaya!';
        return back()->with('success', $msg);
    }
    public function show(User $user) {
    $user->load('profile');
    return view('admin.registered_users.show', compact('user'));
}

public function edit(User $user) {
    $user->load('profile');
    return view('admin.registered_users.edit', compact('user'));
}

public function update(Request $request, User $user) {
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'phone' => 'nullable|string|max:20',
    ]);

    $user->update([
        'name'       => $request->name,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'user_type'  => $request->user_type ?? $user->user_type,
        'is_active'  => $request->boolean('is_active'),
    ]);

    if ($user->profile) {
        $user->profile->update([
            'district' => $request->district,
            'school'   => $request->school,
        ]);
    }

    return redirect()->route('admin.registered-users.index')
        ->with('success', 'User updated!');
}

    public function destroy(User $user) {
        if ($user->hasRole('super_admin')) {
            return back()->with('error', 'Super admin ko delete nahi kar sakte!');
        }
        $user->delete();
        return back()->with('success', 'User deleted!');
    }
}
