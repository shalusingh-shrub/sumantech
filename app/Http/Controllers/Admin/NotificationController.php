<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(20);
        Notification::where('is_read', false)->update(['is_read' => true]);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return redirect($notification->url ?? route('admin.dashboard'));
    }

    public function markAllRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Sab notifications read kar li!');
    }

    public function getUnread()
    {
        $notifications = Notification::where('is_read', false)
            ->latest()->take(10)->get();
        $count = Notification::unreadCount();
        return response()->json([
            'count'         => $count,
            'notifications' => $notifications,
        ]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notification deleted!');
    }
}