<?php
namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\Notification;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        Contact::create($request->only(['name', 'email', 'phone', 'subject', 'message']));

        Notification::send(
            'new_contact',
            'Naya Contact Message!',
            $request->name . ' ne message bheja — ' . Str::limit($request->subject ?? 'No subject', 40),
            route('admin.contacts.index')
        );

        return redirect()->back()->with('success', 'Aapka sandesh safaltapurvak bhej diya gaya. Dhanyavad!');
    }

    public function suggestionBox()
    {
        return view('frontend.suggestion-box');
    }

    public function suggestionStore(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string|max:20',
            'type'    => 'required|in:suggestion,complaint',
            'message' => 'required|string|min:10',
        ]);

        Suggestion::create($request->only(['name', 'email', 'phone', 'type', 'message']));

        Notification::send(
            'new_opinion',
            'Naya Suggestion Aaya!',
            $request->name . ' ne ' . $request->type . ' diya',
            route('admin.suggestions.index')
        );

        return redirect()->back()->with('success', 'Aapka sujhav/shikayat safaltapurvak darj ki gayi. Dhanyavad!');
    }
}