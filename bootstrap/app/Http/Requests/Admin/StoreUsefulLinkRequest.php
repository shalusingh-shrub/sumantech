<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StoreUsefulLinkRequest extends FormRequest {
    public function authorize(): bool { return auth()->check(); }
    public function rules(): array {
        return [
            'title'      => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'url'        => ['required', 'url', 'max:500'],
            'category'   => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array {
        return [
            'title.required' => 'Title is required.',
            'title.min'      => 'Title must be at least 3 characters.',
            'title.regex'    => 'Title cannot contain < > characters.',
            'url.required'   => 'URL is required.',
            'url.url'        => 'Please enter a valid URL.',
        ];
    }
}
