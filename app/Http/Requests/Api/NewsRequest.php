<?php
namespace App\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewsRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|unique:news_events,slug',
            'short_description' => 'nullable|string|max:500',
            'content'           => 'nullable|string',
            'image'             => 'nullable|string',
            'category'          => 'required|in:news,event',
            'event_date'        => 'nullable|date',
            'is_published'      => 'boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
