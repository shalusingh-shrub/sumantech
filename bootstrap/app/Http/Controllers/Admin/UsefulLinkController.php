<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsefulLinkRequest;
use App\Http\Requests\Admin\UpdateUsefulLinkRequest;
use App\Models\UsefulLink;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UsefulLinkController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [new Middleware('auth')];
    }

    public function index() {
        $query = UsefulLink::with('createdBy', 'updatedBy')->orderBy('sort_order');
        if (request('search')) $query->where('title', 'like', '%' . request('search') . '%');
        return view('admin.useful_links.index', ['links' => $query->paginate(20)->withQueryString()]);
    }

    public function create() { return view('admin.useful_links.create'); }

    public function store(StoreUsefulLinkRequest $request) {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        UsefulLink::create($data);
        return redirect()->route('admin.useful-links.index')->with('success', 'Link successfully added!');
    }

    public function edit(UsefulLink $usefulLink) { return view('admin.useful_links.edit', compact('usefulLink')); }

    public function update(UpdateUsefulLinkRequest $request, UsefulLink $usefulLink) {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $usefulLink->update($data);
        return redirect()->route('admin.useful-links.index')->with('success', 'Link successfully updated!');
    }

    public function destroy(UsefulLink $usefulLink) {
        $usefulLink->delete();
        return redirect()->route('admin.useful-links.index')->with('success', 'Link deleted!');
    }
}
