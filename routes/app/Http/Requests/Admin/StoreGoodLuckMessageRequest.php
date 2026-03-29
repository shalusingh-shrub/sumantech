<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StoreGoodLuckMessageRequest extends FormRequest {
    public function authorize(): bool { return auth()->check(); }
    public function rules(): array {
        return [
            'title'     => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'message'   => ['required', 'string', 'max:2000'],
            'author'    => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array {
        return [
            'title.required'   => 'Title is required.',
            'title.min'        => 'Title must be at least 3 characters.',
            'message.required' => 'Message is required.',
            'message.max'      => 'Message must not exceed 2000 characters.',
        ];
    }
}
