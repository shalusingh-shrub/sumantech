<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAwardRequest;
use App\Http\Requests\Admin\UpdateAwardRequest;
use App\Models\Award;
use App\Models\AwardParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AwardController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [new Middleware('auth'), new Middleware('permission:manage_awards')];
    }

    public function index() {
        $query = Award::with('createdBy')->latest();
        if (request('search')) $query->where('title', 'like', '%' . request('search') . '%');
        return view('admin.awards.index', ['awards' => $query->paginate(20)->withQueryString()]);
    }

    public function create() { return view('admin.awards.create'); }

    public function store(StoreAwardRequest $request) {
        $data = $request->except(['image', 'certificate_template', '_token']);
        $data['slug']            = Str::slug($request->title) . '-' . time();
        $data['is_active']       = $request->boolean('is_active');
        $data['has_certificate'] = $request->boolean('has_certificate');
        $data['created_by']      = auth()->id();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('awards', 'public');
            $data['image'] = basename($path);
        }
        if ($request->hasFile('certificate_template')) {
            $path = $request->file('certificate_template')->store('awards/certificates', 'public');
            $data['certificate_template'] = basename($path);
        }
        Award::create($data);
        return redirect()->route('admin.awards.index')->with('success', 'Award successfully added!');
    }

    public function edit(Award $award) { return view('admin.awards.edit', compact('award')); }

    public function update(UpdateAwardRequest $request, Award $award) {
        $data = $request->except(['image', 'certificate_template', '_token', '_method']);
        $data['is_active']       = $request->boolean('is_active');
        $data['has_certificate'] = $request->boolean('has_certificate');
        $data['updated_by']      = auth()->id();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('awards', 'public');
            $data['image'] = basename($path);
        }
        if ($request->hasFile('certificate_template')) {
            $path = $request->file('certificate_template')->store('awards/certificates', 'public');
            $data['certificate_template'] = basename($path);
        }
        $award->update($data);
        return redirect()->route('admin.awards.index')->with('success', 'Award successfully updated!');
    }

    public function destroy(Award $award) {
        $award->delete();
        return redirect()->route('admin.awards.index')->with('success', 'Award deleted!');
    }

    public function participants(Award $award) {
        $participants = $award->participants()->latest()->paginate(20);
        return view('admin.awards.participants', compact('award', 'participants'));
    }

    public function storeParticipant(Request $request, Award $award) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'class'    => 'nullable|string|max:50',
            'school'   => 'nullable|string|max:255',
            'district' => 'nullable|string|max:100',
            'month'    => 'nullable|string|max:50',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $data = $request->except(['photo', '_token']);
        $data['award_id'] = $award->id;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('award_participants', 'public');
            $data['photo'] = basename($path);
        }
        AwardParticipant::create($data);
        return redirect()->back()->with('success', 'Participant added!');
    }

    public function destroyParticipant(AwardParticipant $participant) {
        $participant->delete();
        return redirect()->back()->with('success', 'Participant deleted!');
    }

    public function certificateBuilder(Award $award) {
        return view('admin.awards.certificate_builder', compact('award'));
    }

    public function saveCertLayout(Request $request, Award $award) {
        $award->update(['cert_layout' => $request->layout]);
        return redirect()->back()->with('success', 'Certificate layout saved!');
    }
}
