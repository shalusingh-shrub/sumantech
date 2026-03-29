<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberRequest;
use App\Http\Requests\Admin\UpdateTeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TeamMemberController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:manage_team'),
        ];
    }

    public function index()
    {
        $query = TeamMember::with('createdBy', 'updatedBy')->orderBy('sort_order');

        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('designation', 'like', '%' . request('search') . '%');
        }
        if (request('role_type')) {
            $query->where('role_type', request('role_type'));
        }

        $members = $query->paginate(20)->withQueryString();
        return view('admin.team.index', compact('members'));
    }

    public function create() { return view('admin.team.create'); }

    public function store(StoreTeamMemberRequest $request)
    {
        $data = $request->except(['photo', '_token']);
        $data['created_by'] = auth()->id();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('team', 'public');
            $data['photo'] = basename($path);
        }

        TeamMember::create($data);
        return redirect()->route('admin.team.index')->with('success', 'Team member successfully add ho gaya!');
    }

    public function edit(TeamMember $team) { return view('admin.team.edit', compact('team')); }

    public function update(UpdateTeamMemberRequest $request, TeamMember $team)
    {
        $data = $request->except(['photo', '_token', '_method']);
        $data['updated_by'] = auth()->id();

        if ($request->hasFile('photo')) {
            if ($team->photo) Storage::disk('public')->delete('team/' . $team->photo);
            $path = $request->file('photo')->store('team', 'public');
            $data['photo'] = basename($path);
        }

        $team->update($data);
        return redirect()->route('admin.team.index')->with('success', 'Team member successfully update ho gaya!');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->photo) Storage::disk('public')->delete('team/' . $team->photo);
        $team->delete();
        return redirect()->route('admin.team.index')->with('success', 'Team member delete ho gaya!');
    }

    public function toggleStatus(TeamMember $team)
    {
        $team->update(['is_active' => !$team->is_active]);
        return redirect()->back()->with('success', 'Status update ho gaya!');
    }
}
