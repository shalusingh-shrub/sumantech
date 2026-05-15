<?php
namespace App\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Name is required.',
            'email.required'   => 'Email is required.',
            'email.email'      => 'Valid email dalo.',
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
