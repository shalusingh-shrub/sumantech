<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $allCategories = [
            'Founder', 'Technical Team Leader', 'Technical', 'Writer',
            'Thread', 'Facebook', 'Koo', 'Twitter', 'LinkedIn',
            'YouTube', 'Pinterest', 'WhatsApp', 'Kutumb', 'Instagram',
            'Telegram', 'District Team', 'Media', 'Chetna', 'Publication',
            'Abhimat', 'Online Event', 'News', 'School on Mobile',
            'District Technical Team', 'Block Technical Team', 'Balman',
            'Balmanch', 'Event', 'Pragyanika', 'Poster', 'Karmana', 'Anusandhaanam'
        ];

        $categories = [];
        foreach ($allCategories as $cat) {
            $members = Team::where('status', true)->where('category', $cat)->orderBy('order')->get();
            if ($members->count() > 0) {
                $categories[$cat] = $members;
            }
        }

        return view('team.index', compact('categories'));
    }

    public function category($category)
    {
        $categoryName = str_replace('-', ' ', $category);
        $members = Team::where('status', true)
            ->where('category', $categoryName)
            ->orderBy('order')
            ->get();
        return view('team.category', compact('members', 'categoryName'));
    }

    public function adminIndex()
    {
        $teams = Team::orderBy('category')->orderBy('order')->paginate(20);
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $categories = [
            'Founder', 'Technical Team Leader', 'Technical', 'Writer',
            'Thread', 'Facebook', 'Koo', 'Twitter', 'LinkedIn',
            'YouTube', 'Pinterest', 'WhatsApp', 'Kutumb', 'Instagram',
            'Telegram', 'District Team', 'Media', 'Chetna', 'Publication',
            'Abhimat', 'Online Event', 'News', 'School on Mobile',
            'District Technical Team', 'Block Technical Team', 'Balman',
            'Balmanch', 'Event', 'Pragyanika', 'Poster', 'Karmana', 'Anusandhaanam'
        ];
        return view('admin.teams.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
            'block' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'contribution' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'is_featured' => 'boolean',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/user'), $name);
            $validated['image'] = $name;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['status'] = $request->has('status');

        Team::create($validated);
        return redirect()->route('admin.teams.index')->with('success', 'Team member added!');
    }

    public function edit($id)
    {
        $team = Team::findOrFail($id);
        $categories = [
            'Founder', 'Technical Team Leader', 'Technical', 'Writer',
            'Thread', 'Facebook', 'Koo', 'Twitter', 'LinkedIn',
            'YouTube', 'Pinterest', 'WhatsApp', 'Kutumb', 'Instagram',
            'Telegram', 'District Team', 'Media', 'Chetna', 'Publication',
            'Abhimat', 'Online Event', 'News', 'School on Mobile',
            'District Technical Team', 'Block Technical Team', 'Balman',
            'Balmanch', 'Event', 'Pragyanika', 'Poster', 'Karmana', 'Anusandhaanam'
        ];
        return view('admin.teams.edit', compact('team', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/user'), $name);
            $validated['image'] = $name;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['status'] = $request->has('status');
        $validated['designation'] = $request->designation;
        $validated['school'] = $request->school;
        $validated['block'] = $request->block;
        $validated['district'] = $request->district;
        $validated['contribution'] = $request->contribution;
        $validated['description'] = $request->description;
        $validated['order'] = $request->order;

        $team->update($validated);
        return redirect()->route('admin.teams.index')->with('success', 'Team member updated!');
    }

    public function destroy($id)
    {
        Team::findOrFail($id)->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Team member deleted!');
    }
}
