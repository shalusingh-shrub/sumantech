<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactRequest;
use App\Http\Requests\Api\SuggestionRequest;
use App\Http\Requests\Api\OpinionRequest;
use App\Models\Contact;
use App\Models\Suggestion;
use App\Models\Opinion;
use Illuminate\Http\JsonResponse;

class FormController extends Controller
{
    /**
     * POST /api/contact
     */
    public function contactStore(ContactRequest $request): JsonResponse
    {
        $contact = Contact::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Message bhej diya gaya! Hum jald sampark karenge.',
            'data'    => $contact,
        ], 201);
    }

    /**
     * POST /api/suggestion
     */
    public function suggestionStore(SuggestionRequest $request): JsonResponse
    {
        $suggestion = Suggestion::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Shukriya! Aapka message mil gaya.',
            'data'    => $suggestion,
        ], 201);
    }

    /**
     * POST /api/opinion
     */
    public function opinionStore(OpinionRequest $request): JsonResponse
    {
        $opinion = Opinion::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Aapki ray mil gayi! Shukriya.',
            'data'    => $opinion,
        ], 201);
    }
}
