<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    public function index(Request $request) {
        $query = User::query();
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
                  ->orWhere('phone', 'like', '%'.$request->search.'%')
                  ->orWhere('district', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->user_type) $query->where('user_type', $request->user_type);
        if ($request->status !== null && $request->status !== '') $query->where('is_active', $request->status);

        $users = $query->latest()->paginate(20)->withQueryString();
        $stats = [
            'total'    => User::count(),
            'teachers' => User::where('user_type', 'teacher')->count(),
            'students' => User::where('user_type', 'student')->count(),
            'active'   => User::where('is_active', true)->count(),
        ];
        return view('admin.registered_users.index', compact('users', 'stats'));
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

    public function destroy(User $user) {
        if ($user->hasRole('super_admin')) {
            return back()->with('error', 'Super admin ko delete nahi kar sakte!');
        }
        $user->delete();
        return back()->with('success', 'User deleted!');
    }
}
