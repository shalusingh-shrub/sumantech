<?php
// File: app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Suggestion;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        Contact::create($request->only(['name', 'email', 'phone', 'subject', 'message']));

        return redirect()->back()->with('success', 'Your message has been sent successfully. Thank you!');
    }

    public function suggestionBox()
    {
        return view('frontend.suggestion-box');
    }

    public function suggestionStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'type' => 'required|in:suggestion,complaint',
            'message' => 'required|string|min:10',
        ]);

        Suggestion::create($request->only(['name', 'email', 'phone', 'type', 'message']));

        return redirect()->back()->with('success', 'Your suggestion/complaint has been submitted successfully. Thank you!');
    }
}
