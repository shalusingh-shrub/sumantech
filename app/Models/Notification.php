<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type', 'title', 'message', 'icon',
        'color', 'url', 'is_read', 'user_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public static function send($type, $title, $message, $url = null)
    {
        $icons = [
            'new_student'  => 'fas fa-user-plus',
            'new_contact'  => 'fas fa-envelope',
            'new_opinion'  => 'fas fa-comment-dots',
            'invoice_due'  => 'fas fa-file-invoice-dollar',
            'new_quiz'     => 'fas fa-question-circle',
        ];
        $colors = [
            'new_student'  => '#28a745',
            'new_contact'  => '#1a2a6c',
            'new_opinion'  => '#6f42c1',
            'invoice_due'  => '#dc3545',
            'new_quiz'     => '#F0A500',
        ];

        self::create([
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'icon'    => $icons[$type] ?? 'fas fa-bell',
            'color'   => $colors[$type] ?? '#1a2a6c',
            'url'     => $url,
            'is_read' => false,
        ]);
    }

    public static function unreadCount()
    {
        return self::where('is_read', false)->count();
    }
}