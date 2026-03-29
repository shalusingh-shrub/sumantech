<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Models\Gallery;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GalleryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:manage_gallery'),
        ];
    }

    public function index()
    {
        $query = Gallery::with('createdBy', 'updatedBy')->latest();

        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }
        if (request('type')) {
            $query->where('type', request('type'));
        }

        $galleries = $query->paginate(20)->withQueryString();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create() { return view('admin.gallery.create'); }

    public function store(StoreGalleryRequest $request)
    {
        $data = $request->except(['image', '_token']);
        $data['is_active']  = $request->boolean('is_active');
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            $data['image'] = basename($path);
        }

        Gallery::create($data);
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item successfully add ho gaya!');
    }

    public function edit(Gallery $gallery) { return view('admin.gallery.edit', compact('gallery')); }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->except(['image', '_token', '_method']);
        $data['is_active']  = $request->boolean('is_active');
        $data['updated_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            $data['image'] = basename($path);
        }

        $gallery->update($data);
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item successfully update ho gaya!');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item delete ho gaya!');
    }
}
