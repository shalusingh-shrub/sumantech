<?php
namespace App\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PublicationRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'          => 'required|string|max:255',
            'slug'           => 'required|string|unique:publications,slug',
            'description'    => 'nullable|string',
            'cover_image'    => 'nullable|string',
            'file'           => 'nullable|string',
            'category'       => 'required|in:science_corner,tlm,anusandhaanam,abhimat,emagazine,karmana,balman,suvichar,eresources',
            'issue_number'   => 'nullable|string|max:50',
            'published_date' => 'nullable|date',
            'is_active'      => 'boolean',
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
