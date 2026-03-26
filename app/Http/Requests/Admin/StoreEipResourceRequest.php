<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreEipResourceRequest extends FormRequest {
    public function authorize(): bool { return auth()->check(); }
    protected function prepareForValidation(): void {
        if ($this->title) $this->merge(['slug' => Str::slug($this->title) . '-' . time()]);
    }
    public function rules(): array {
        return [
            'title'       => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'description' => ['nullable', 'string', 'max:2000'],
            'link'        => ['nullable', 'url', 'max:500'],
            'category'    => ['nullable', 'string', 'max:100'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array {
        return [
            'title.required' => 'Title is required.',
            'title.min'      => 'Title must be at least 3 characters.',
            'title.regex'    => 'Title cannot contain < > characters.',
            'link.url'       => 'Please enter a valid URL.',
            'image.image'    => 'Only image files are allowed.',
            'image.mimes'    => 'Image must be JPG, PNG or WebP format.',
            'image.max'      => 'Image size must not exceed 2MB.',
        ];
    }
}
