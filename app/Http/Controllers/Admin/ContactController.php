<?php
// File: app/Http/Controllers/Admin/ContactController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Suggestion;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ContactController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:manage_contacts'),
        ];
    }

    public function index(\Illuminate\Http\Request $request) {
        $query = Contact::latest();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
                  ->orWhere('subject', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('status')) {
            $query->where('is_read', $request->status);
        }
        $contacts = $query->paginate($request->get('per_page', 10))->withQueryString();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact) {
        $contact->update(['is_read' => true]);
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact) {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Deleted!');
    }

    public function suggestions() {
        $suggestions = Suggestion::latest()->paginate(20);
        return view('admin.contacts.suggestions', compact('suggestions'));
    }

    public function showSuggestion(Suggestion $suggestion) {
        $suggestion->update(['is_read' => true]);
        return view('admin.contacts.show-suggestion', compact('suggestion'));
    }
}
