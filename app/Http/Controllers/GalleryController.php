<?php
namespace App\Http\Controllers;

use App\Models\GalleryGroup;

class GalleryController extends Controller
{
    public function imageGallery()
    {
        $galleries = GalleryGroup::where('type', 'image')
                        ->where('is_active', true)
                        ->withCount('items')
                        ->with(['items' => function($q) {
                            $q->limit(4);
                        }])
                        ->latest()
                        ->paginate(12);
        return view('frontend.gallery.image', compact('galleries'));
    }

    public function videoGallery()
    {
        $galleries = GalleryGroup::where('type', 'video')
                        ->where('is_active', true)
                        ->withCount('items')
                        ->with('items')
                        ->latest()
                        ->paginate(12);
        return view('frontend.gallery.video', compact('galleries'));
    }

    public function media()
    {
        $galleries = GalleryGroup::where('is_active', true)
                        ->withCount('items')
                        ->with(['items' => function($q) {
                            $q->limit(4);
                        }])
                        ->latest()
                        ->paginate(12);
        return view('frontend.gallery.media', compact('galleries'));
    }

    public function show($slug)
    {
        $gallery = GalleryGroup::where('slug', $slug)
                        ->where('is_active', true)
                        ->with('items')
                        ->firstOrFail();
        return view('frontend.gallery.show', compact('gallery'));
    }
}