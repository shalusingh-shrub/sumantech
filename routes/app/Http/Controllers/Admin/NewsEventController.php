<?php
// File: app/Http/Controllers/Admin/NewsEventController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsRequest;
use App\Http\Requests\Admin\UpdateNewsRequest;
use App\Models\NewsCategory;
use App\Models\NewsEvent;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NewsEventController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:manage_news'),
        ];
    }

    public function index()
    {
        $query = NewsEvent::with('newsCategory')->latest();

        if (request('search')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('slug', 'like', '%' . request('search') . '%');
            });
        }
        if (request('type')) {
            $query->where('category', request('type'));
        }
        if (request('status') !== null && request('status') !== '') {
            $query->where('is_published', request('status'));
        }

        $news = $query->paginate(20)->withQueryString();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.news.create', compact('categories'));
    }

    // StoreNewsRequest — store ke liye
    public function store(StoreNewsRequest $request)
    {
        $data = $request->except(['image', '_token', 'auto_slug']);

        $data['is_published'] = $request->input('status') === 'active';
        $data['pin_to_home']  = $request->input('pin_to_home') === 'yes';
        $data['category']     = $request->input('news_type', 'news');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $data['image'] = basename($path);
        }

        NewsEvent::create($data);
        return redirect()->route('admin.news.index')
            ->with('success', 'News/Event successfully add ho gaya!');
    }

    public function edit(NewsEvent $news)
    {
        $categories = NewsCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    // UpdateNewsRequest — update ke liye
    public function update(UpdateNewsRequest $request, NewsEvent $news)
    {
        $data = $request->except(['image', '_token', '_method', 'auto_slug']);

        $data['is_published'] = $request->input('status') === 'active';
        $data['pin_to_home']  = $request->input('pin_to_home') === 'yes';
        $data['category']     = $request->input('news_type', 'news');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $data['image'] = basename($path);
        }

        $news->update($data);
        return redirect()->route('admin.news.index')
            ->with('success', 'Successfully update ho gaya!');
    }

    public function destroy(NewsEvent $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')
            ->with('success', 'Successfully delete ho gaya!');
    }
}
