<?php
// File: app/Http/Controllers/PublicationController.php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function scienceCorner()
    {
        $publications = Publication::where('category', 'science_corner')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.publications.list', [
            'publications' => $publications,
            'title' => 'Science Corner',
            'category' => 'science_corner',
        ]);
    }

    public function tlm()
    {
        $publications = Publication::where('category', 'tlm')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.publications.list', [
            'publications' => $publications,
            'title' => 'TLM - Teaching Learning Material',
            'category' => 'tlm',
        ]);
    }

    public function anusandhaanam()
    {
        $publications = Publication::where('category', 'anusandhaanam')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.publications.list', ['publications' => $publications, 'title' => 'Research', 'category' => 'anusandhaanam']);
    }

    public function abhimat()
    {
        $publications = Publication::where('category', 'abhimat')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.publications.list', ['publications' => $publications, 'title' => 'Opinion', 'category' => 'abhimat']);
    }

    public function emagazine()
    {
        $publications = Publication::where('category', 'emagazine')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.publications.list', ['publications' => $publications, 'title' => 'E-Magazine', 'category' => 'emagazine']);
    }

    public function karmana()
    {
        $publications = Publication::where('category', 'karmana')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.publications.list', ['publications' => $publications, 'title' => 'Action', 'category' => 'karmana']);
    }

    public function balman()
    {
        $publications = Publication::where('category', 'balman')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.publications.list', ['publications' => $publications, 'title' => 'Young Minds', 'category' => 'balman']);
    }

    public function suvichar()
    {
        $publications = Publication::where('category', 'suvichar')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.publications.list', ['publications' => $publications, 'title' => 'Thought of the Day', 'category' => 'suvichar']);
    }

    public function eresources()
    {
        $publications = Publication::where('category', 'eresources')->where('is_active', true)->latest()->paginate(12);
        return view('frontend.publications.list', ['publications' => $publications, 'title' => 'e-Resources', 'category' => 'eresources']);
    }

    public function show($slug)
    {
        $publication = Publication::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.publications.show', compact('publication'));
    }
}
