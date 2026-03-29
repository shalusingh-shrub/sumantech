<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEipResourceRequest;
use App\Http\Requests\Admin\UpdateEipResourceRequest;
use App\Models\EipResource;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EipResourceController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [new Middleware('auth')];
    }

    public function index() {
        $query = EipResource::with('createdBy', 'updatedBy')->latest();
        if (request('search')) $query->where('title', 'like', '%' . request('search') . '%');
        if (request('category')) $query->where('category', request('category'));
        return view('admin.eip_resources.index', ['resources' => $query->paginate(20)->withQueryString()]);
    }

    public function create() { return view('admin.eip_resources.create'); }

    public function store(StoreEipResourceRequest $request) {
        $data = $request->except(['image', '_token']);
        $data['slug']      = Str::slug($request->title) . '-' . time();
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) { $path = $request->file('image')->store('eip', 'public'); $data['image'] = basename($path); }
        EipResource::create($data);
        return redirect()->route('admin.eip-resources.index')->with('success', 'E-Resource successfully added!');
    }

    public function edit(EipResource $eipResource) { return view('admin.eip_resources.edit', compact('eipResource')); }

    public function update(UpdateEipResourceRequest $request, EipResource $eipResource) {
        $data = $request->except(['image', '_token', '_method']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) { $path = $request->file('image')->store('eip', 'public'); $data['image'] = basename($path); }
        $eipResource->update($data);
        return redirect()->route('admin.eip-resources.index')->with('success', 'E-Resource successfully updated!');
    }

    public function destroy(EipResource $eipResource) {
        $eipResource->delete();
        return redirect()->route('admin.eip-resources.index')->with('success', 'E-Resource deleted!');
    }
}
