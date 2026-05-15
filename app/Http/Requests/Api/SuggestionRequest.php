<?php
namespace App\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SuggestionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'type'    => 'required|in:suggestion,complaint',
            'message' => 'required|string|min:10',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Name is required.',
            'type.required'    => 'Type is required: suggestion or complaint.',
            'type.in'          => 'Type must be either suggestion or complaint.',
            'message.required' => 'Message is required.',
            'message.min'      => 'Message must be at least 10 characters.',
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
