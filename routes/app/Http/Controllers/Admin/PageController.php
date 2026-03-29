<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PageController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [new Middleware('auth')];
    }

    public function index() {
        $query = Page::with('createdBy', 'updatedBy')->latest();
        if (request('search')) $query->where('title', 'like', '%' . request('search') . '%');
        return view('admin.pages.index', ['pages' => $query->paginate(20)->withQueryString()]);
    }

    public function create() { return view('admin.pages.create'); }

    public function store(StorePageRequest $request) {
        $data = $request->except(['banner_image', '_token']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('banner_image')) { $path = $request->file('banner_image')->store('pages', 'public'); $data['banner_image'] = basename($path); }
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page successfully added!');
    }

    public function edit(Page $page) { return view('admin.pages.edit', compact('page')); }

    public function update(UpdatePageRequest $request, Page $page) {
        $data = $request->except(['banner_image', '_token', '_method']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('banner_image')) { $path = $request->file('banner_image')->store('pages', 'public'); $data['banner_image'] = basename($path); }
        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page successfully updated!');
    }

    public function destroy(Page $page) {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted!');
    }
}
