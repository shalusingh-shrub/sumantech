<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest {
    public function authorize(): bool { return auth()->check(); }
    public function rules(): array {
        return [
            'quiz_name'   => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array {
        return [
            'quiz_name.required' => 'Quiz name is required.',
            'quiz_name.min'      => 'Quiz name must be at least 3 characters.',
            'quiz_name.regex'    => 'Quiz name cannot contain < > characters.',
        ];
    }
}
