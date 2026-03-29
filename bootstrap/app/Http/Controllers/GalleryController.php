<?php
// File: app/Http/Controllers/GalleryController.php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryController extends Controller
{
    public function imageGallery()
    {
        $images = Gallery::where('type', 'image')->where('is_active', true)->latest()->paginate(24);
        return view('frontend.gallery.image', compact('images'));
    }

    public function videoGallery()
    {
        $videos = Gallery::where('type', 'video')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.gallery.video', compact('videos'));
    }

    public function media()
    {
        $items = Gallery::where('type', 'media')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.gallery.media', compact('items'));
    }
}
