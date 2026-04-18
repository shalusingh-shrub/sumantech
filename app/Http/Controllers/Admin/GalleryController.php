<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryGroup;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = GalleryGroup::withCount('items')->latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'slug'         => 'nullable|string|unique:gallery_groups,slug',
            'type'         => 'required|in:image,video',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'description'  => 'required|string',
            'meta_data'    => 'required|string',
            'meta_keyword' => 'required|string',
            'cover_image'  => 'nullable|image|max:2048',
        ]);

        $data = $request->except('cover_image');
        $data['slug']         = $request->slug ?: Str::slug($request->name);
        $data['pin_to_home']  = $request->boolean('pin_to_home');
        $data['is_active']    = $request->boolean('is_active', true);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        $gallery = GalleryGroup::create($data);
        return redirect()->route('admin.gallery.index')
                         ->with('success', 'Gallery created! Ab images/videos add karo.');
    }

    public function edit(GalleryGroup $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, GalleryGroup $gallery)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'slug'         => 'nullable|string|unique:gallery_groups,slug,' . $gallery->id,
            'type'         => 'required|in:image,video',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'description'  => 'required|string',
            'meta_data'    => 'required|string',
            'meta_keyword' => 'required|string',
            'cover_image'  => 'nullable|image|max:2048',
        ]);

        $data = $request->except('cover_image');
        $data['slug']        = $request->slug ?: Str::slug($request->name);
        $data['pin_to_home'] = $request->boolean('pin_to_home');
        $data['is_active']   = $request->boolean('is_active');

        if ($request->hasFile('cover_image')) {
            if ($gallery->cover_image) Storage::disk('public')->delete($gallery->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        $gallery->update($data);
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery updated!');
    }

    public function destroy(GalleryGroup $gallery)
    {
        foreach ($gallery->items as $item) {
            if ($item->file_path)  Storage::disk('public')->delete($item->file_path);
            if ($item->video_file) Storage::disk('public')->delete($item->video_file);
        }
        if ($gallery->cover_image) Storage::disk('public')->delete($gallery->cover_image);
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery deleted!');
    }

    // Gallery Items manage karo
    public function manageItems(GalleryGroup $gallery)
    {
        $items = $gallery->items()->get();
        return view('admin.gallery.items', compact('gallery', 'items'));
    }

    public function storeItems(Request $request, GalleryGroup $gallery)
    {
        if ($gallery->type === 'image') {
            $request->validate([
                'images'   => 'required|array|max:5',
                'images.*' => 'image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            ]);
            $title = $request->title ?: null;
            foreach ($request->file('images') as $img) {
                $path = $img->store('gallery/images', 'public');
                GalleryItem::create([
                    'gallery_group_id' => $gallery->id,
                    'title'            => $title,
                    'slug'             => $title ? Str::slug($title) . '-' . uniqid() : null,
                    'file_path'        => $path,
                ]);
            }
        } else {
            $request->validate([
                'video_source' => 'required|in:url,file',
            ]);
            if ($request->video_source === 'url') {
                $request->validate(['video_url' => 'required|url']);
                GalleryItem::create([
                    'gallery_group_id' => $gallery->id,
                    'title'            => $request->title,
                    'slug'             => $request->title ? Str::slug($request->title) . '-' . uniqid() : null,
                    'video_url'        => $request->video_url,
                ]);
            } else {
                $request->validate(['video_file' => 'required|mimes:mp4,avi,mov,mkv|max:51200']);
                $path = $request->file('video_file')->store('gallery/videos', 'public');
                GalleryItem::create([
                    'gallery_group_id' => $gallery->id,
                    'title'            => $request->title,
                    'slug'             => $request->title ? Str::slug($request->title) . '-' . uniqid() : null,
                    'video_file'       => $path,
                ]);
            }
        }

        return redirect()->route('admin.gallery.items', $gallery)
                         ->with('success', 'Items added successfully!');
    }

    public function deleteItem(GalleryItem $item)
    {
        $gallery = $item->group;
        if ($item->file_path)  Storage::disk('public')->delete($item->file_path);
        if ($item->video_file) Storage::disk('public')->delete($item->video_file);
        $item->delete();
        return redirect()->route('admin.gallery.items', $gallery)
                         ->with('success', 'Item deleted!');
    }
}