<?php
// File: app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\TopFlash;
use App\Models\NewsEvent;
use App\Models\Publication;
use App\Models\Testimonial;
use App\Models\TeamMember;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)->orderBy('sort_order')->get();
        $topFlashes = TopFlash::where('is_active', true)->orderBy('sort_order')->get();
        $latestNews = NewsEvent::where('is_published', true)->latest()->take(6)->get();
        $testimonials = Testimonial::where('is_active', true)->inRandomOrder()->take(3)->get();
        $latestPublications = Publication::where('is_active', true)->latest()->take(8)->get();

        return view('frontend.home', compact(
            'sliders', 'topFlashes', 'latestNews', 'testimonials', 'latestPublications'
        ));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function team()
    {
        $founders = TeamMember::where('role_type', 'founder')->where('is_active', true)->orderBy('sort_order')->get();
        $coFounders = TeamMember::where('role_type', 'co_founder')->where('is_active', true)->orderBy('sort_order')->get();
        $advisors = TeamMember::where('role_type', 'advisor')->where('is_active', true)->orderBy('sort_order')->get();
        $coreTeam = TeamMember::where('role_type', 'core_team')->where('is_active', true)->orderBy('sort_order')->get();
        $lecturers = TeamMember::where('role_type', 'lecturer')->where('is_active', true)->orderBy('sort_order')->get();
        $members = TeamMember::where('role_type', 'member')->where('is_active', true)->orderBy('sort_order')->get();

        return view('frontend.team', compact('founders', 'coFounders', 'advisors', 'coreTeam', 'lecturers', 'members'));
    }

    public function teamMemberDetail($id)
    {
        $member = TeamMember::findOrFail($id);
        return response()->json($member);
    }

    public function baglessSaturday()
    {
        $page = \App\Models\Page::where('slug', 'bagless-saturday')->first();
        return view('frontend.page', compact('page'));
    }

    public function letsTalk()
    {
        $page = \App\Models\Page::where('slug', 'lets-talk')->first();
        return view('frontend.page', compact('page'));
    }

    public function shiksaShruti()
    {
        return view('frontend.shiksha-shruti');
    }

    public function projectShikshakSathi()
    {
        $page = \App\Models\Page::where('slug', 'project-shikshak-sathi')->first();
        return view('frontend.page', compact('page'));
    }

    public function eip()
    {
        $resources = \App\Models\EipResource::where('is_active', true)->get();
        return view('frontend.eip', compact('resources'));
    }

    public function competition()
    {
        $competitions = \App\Models\Competition::where('is_active', true)->latest()->paginate(9);
        return view('frontend.competition', compact('competitions'));
    }

    public function competitionShow($slug)
    {
        $comp = \App\Models\Competition::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.competition_show', compact('comp'));
    }

    public function award()
    {
        $awards = \App\Models\Award::where('is_active', true)->orderBy('year', 'desc')->get();
        return view('frontend.award', compact('awards'));
    }

    public function awardShow($slug)
    {
        $award = \App\Models\Award::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $participants = $award->participants()->where('is_active', true)->latest()->paginate(12);
        return view('frontend.award_show', compact('award', 'participants'));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('is_active', true)->paginate(12);
        return view('frontend.testimonials', compact('testimonials'));
    }

    public function yourOpinion()
    {
        $opinions = \App\Models\Opinion::where('is_approved', true)->latest()->paginate(10);
        return view('frontend.your-opinion', compact('opinions'));
    }

    public function yourOpinionStore(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'district' => 'nullable|string|max:100',
            'school' => 'nullable|string|max:255',
            'opinion' => 'required|string|min:10',
        ]);

        \App\Models\Opinion::create($request->only(['name', 'email', 'district', 'school', 'opinion']));

        return redirect()->back()->with('success', 'आपकी राय सफलतापूर्वक जमा की गई। धन्यवाद!');
    }
    public function courses()
{
    $courses = \App\Models\Course::where('is_active', true)->get();
    return view('frontend.courses', compact('courses'));
}

public function courseShow($id)
{
    $course = \App\Models\Course::where('is_active', true)->findOrFail($id);
    return view('frontend.course_show', compact('course'));
}

    public function podcast()
    {
        return view('frontend.podcast');
    }
}
