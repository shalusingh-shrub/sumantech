<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCompetitionRequest;
use App\Http\Requests\Admin\UpdateCompetitionRequest;
use App\Models\Competition;
use App\Models\CompetitionParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CompetitionController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [new Middleware('auth'), new Middleware('permission:manage_competitions')];
    }

    public function index() {
        $query = Competition::with('createdBy', 'updatedBy')->latest();
        if (request('search')) $query->where('title', 'like', '%' . request('search') . '%');
        if (request('status') !== null && request('status') !== '') $query->where('is_active', request('status'));
        $competitions = $query->paginate(20)->withQueryString();
        return view('admin.competitions.index', compact('competitions'));
    }

    public function create() { return view('admin.competitions.create'); }

    public function store(StoreCompetitionRequest $request) {
        $data = $request->except(['image', 'winner_certificate', 'participation_certificate', 'audience_certificate', '_token']);
        $data['slug']                        = Str::slug($request->title) . '-' . time();
        $data['is_active']                   = $request->boolean('is_active');
        $data['is_participation_cert_allow'] = $request->boolean('is_participation_cert_allow');
        $data['is_auto_gen_certificate']     = $request->boolean('is_auto_gen_certificate');
        $data['created_by']                  = auth()->id();
        if ($request->hasFile('image')) { $data['image'] = basename($request->file('image')->store('competitions', 'public')); }
        foreach (['winner_certificate', 'participation_certificate', 'audience_certificate'] as $cert) {
            if ($request->hasFile($cert)) { $data[$cert] = basename($request->file($cert)->store('competitions/certificates', 'public')); }
        }
        Competition::create($data);
        return redirect()->route('admin.competitions.index')->with('success', 'Competition successfully added!');
    }

    public function show(Competition $competition) { return view('admin.competitions.show', compact('competition')); }
    public function edit(Competition $competition) { return view('admin.competitions.edit', compact('competition')); }

    public function update(UpdateCompetitionRequest $request, Competition $competition) {
        $data = $request->except(['image', 'winner_certificate', 'participation_certificate', 'audience_certificate', '_token', '_method']);
        $data['is_active']                   = $request->boolean('is_active');
        $data['is_participation_cert_allow'] = $request->boolean('is_participation_cert_allow');
        $data['is_auto_gen_certificate']     = $request->boolean('is_auto_gen_certificate');
        $data['updated_by']                  = auth()->id();
        if ($request->hasFile('image')) { $data['image'] = basename($request->file('image')->store('competitions', 'public')); }
        foreach (['winner_certificate', 'participation_certificate', 'audience_certificate'] as $cert) {
            if ($request->hasFile($cert)) { $data[$cert] = basename($request->file($cert)->store('competitions/certificates', 'public')); }
        }
        $competition->update($data);
        return redirect()->route('admin.competitions.index')->with('success', 'Competition successfully updated!');
    }

    public function destroy(Competition $competition) {
        $competition->delete();
        return redirect()->route('admin.competitions.index')->with('success', 'Competition deleted!');
    }

    // Certificate Builder
    public function certBuilder(Competition $competition) {
        return view('admin.certificate_builder', [
            'model'     => $competition,
            'certUrl'   => $competition->participation_cert_url ?? $competition->winner_cert_url,
            'backRoute' => route('admin.competitions.participants', $competition),
            'editRoute' => route('admin.competitions.edit', $competition),
            'saveRoute' => route('admin.competitions.saveCertLayout', $competition),
            'type'      => 'competition',
        ]);
    }

    public function saveCertLayout(Request $request, Competition $competition) {
        $competition->update(['cert_layout' => $request->layout]);
        return redirect()->back()->with('success', 'Certificate layout saved!');
    }

    // Participants
    public function participants(Competition $competition) {
        $participants = $competition->participants()->latest()->paginate(20);
        return view('admin.competitions.participants', compact('competition', 'participants'));
    }

    public function updateParticipant(Request $request, CompetitionParticipant $participant) {
        $participant->update(['status' => $request->status, 'remarks' => $request->remarks]);
        return redirect()->back()->with('success', 'Participant status updated!');
    }
}
