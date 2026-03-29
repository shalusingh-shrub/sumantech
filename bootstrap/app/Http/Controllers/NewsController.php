<?php
// File: app/Http/Controllers/NewsController.php

namespace App\Http\Controllers;

use App\Models\NewsEvent;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = NewsEvent::where('is_published', true)->latest()->paginate(12);
        return view('frontend.news.index', compact('news'));
    }

    public function show($slug)
    {
        $item = NewsEvent::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $related = NewsEvent::where('is_published', true)->where('id', '!=', $item->id)->latest()->take(4)->get();
        return view('frontend.news.show', compact('item', 'related'));
    }
}
