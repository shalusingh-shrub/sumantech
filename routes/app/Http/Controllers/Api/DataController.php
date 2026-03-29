<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsEvent;
use App\Models\Publication;
use App\Models\Gallery;
use App\Models\TeamMember;
use App\Models\Award;
use App\Models\Competition;
use App\Models\Testimonial;
use App\Models\Slider;
use App\Models\TopFlash;
use App\Models\Contact;
use App\Models\Suggestion;
use App\Models\Opinion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    // =============================================
    // GET /api/sliders
    // Homepage slider images
    // =============================================
    public function sliders(): JsonResponse
    {
        $sliders = Slider::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $sliders,
            'total'   => $sliders->count(),
        ]);
    }

    // =============================================
    // GET /api/news
    // GET /api/news/{slug}
    // News & Events
    // =============================================
    public function news(Request $request): JsonResponse
    {
        $query = NewsEvent::where('is_published', true)->latest();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $news = $query->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $news->items(),
            'total'   => $news->total(),
            'pages'   => $news->lastPage(),
        ]);
    }

    public function newsDetail($slug): JsonResponse
    {
        $news = NewsEvent::where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News nahi mili',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $news,
        ]);
    }

    // =============================================
    // GET /api/publications
    // GET /api/publications/{slug}
    // Publications (Science Corner, TLM, eMagazine etc)
    // =============================================
    public function publications(Request $request): JsonResponse
    {
        $query = Publication::where('is_active', true)->latest();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $publications = $query->paginate(10);

        return response()->json([
            'success'    => true,
            'data'       => $publications->items(),
            'total'      => $publications->total(),
            'pages'      => $publications->lastPage(),
            'categories' => [
                'science_corner', 'tlm', 'anusandhaanam',
                'abhimat', 'emagazine', 'karmana',
                'balman', 'suvichar', 'eresources'
            ],
        ]);
    }

    public function publicationDetail($slug): JsonResponse
    {
        $publication = Publication::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$publication) {
            return response()->json([
                'success' => false,
                'message' => 'Publication nahi mili',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $publication,
        ]);
    }

    // =============================================
    // GET /api/gallery
    // Gallery (Image, Video, Media)
    // =============================================
    public function gallery(Request $request): JsonResponse
    {
        $query = Gallery::where('is_active', true)->latest();

        if ($request->has('type')) {
            $query->where('type', $request->type); // image, video, media
        }

        $gallery = $query->paginate(12);

        return response()->json([
            'success' => true,
            'data'    => $gallery->items(),
            'total'   => $gallery->total(),
            'pages'   => $gallery->lastPage(),
        ]);
    }

    // =============================================
    // GET /api/team
    // GET /api/team/{id}
    // Team Members
    // =============================================
    public function team(): JsonResponse
    {
        $team = TeamMember::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $team,
            'total'   => $team->count(),
        ]);
    }

    public function teamDetail($id): JsonResponse
    {
        $member = TeamMember::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Team member nahi mila',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $member,
        ]);
    }

    // =============================================
    // GET /api/awards
    // Awards
    // =============================================
    public function awards(): JsonResponse
    {
        $awards = Award::where('is_active', true)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $awards,
            'total'   => $awards->count(),
        ]);
    }

    // =============================================
    // GET /api/competitions
    // Competitions
    // =============================================
    public function competitions(): JsonResponse
    {
        $competitions = Competition::where('is_active', true)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $competitions,
            'total'   => $competitions->count(),
        ]);
    }

    // =============================================
    // GET /api/testimonials
    // Testimonials
    // =============================================
    public function testimonials(): JsonResponse
    {
        $testimonials = Testimonial::where('is_active', true)
            ->inRandomOrder()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $testimonials,
            'total'   => $testimonials->count(),
        ]);
    }

    // =============================================
    // GET /api/topflash
    // Top Flash news ticker
    // =============================================
    public function topFlash(): JsonResponse
    {
        $topFlash = TopFlash::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $topFlash,
            'total'   => $topFlash->count(),
        ]);
    }

    // =============================================
    // POST /api/contact
    // Contact form submit
    // =============================================
    public function contactStore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $contact = Contact::create($request->only([
            'name', 'email', 'phone', 'subject', 'message'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Message bhej diya gaya! Hum jald sampark karenge.',
            'data'    => $contact,
        ], 201);
    }

    // =============================================
    // POST /api/suggestion
    // Suggestion / Complaint form
    // =============================================
    public function suggestionStore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'message' => 'required|string',
            'type'    => 'required|in:suggestion,complaint',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $suggestion = Suggestion::create($request->only([
            'name', 'email', 'phone', 'type', 'message'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Shukriya! Aapka message mil gaya.',
            'data'    => $suggestion,
        ], 201);
    }

    // =============================================
    // POST /api/opinion
    // Your Opinion form
    // =============================================
    public function opinionStore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'opinion'  => 'required|string',
            'email'    => 'nullable|email',
            'district' => 'nullable|string|max:255',
            'school'   => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $opinion = Opinion::create($request->only([
            'name', 'email', 'district', 'school', 'opinion'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Aapki ray mil gayi! Shukriya.',
            'data'    => $opinion,
        ], 201);
    }
}
