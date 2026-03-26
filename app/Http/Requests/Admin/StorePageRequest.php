<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StorePageRequest extends FormRequest {
    public function authorize(): bool { return auth()->check(); }
    protected function prepareForValidation(): void {
        if ($this->title) $this->merge(['slug' => Str::slug($this->title)]);
    }
    public function rules(): array {
        return [
            'title'        => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'slug'         => ['required', 'string', 'max:255', 'unique:pages,slug'],
            'content'      => ['required', 'string'],
            'banner_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'    => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array {
        return [
            'title.required'   => 'Title is required.',
            'content.required' => 'Content is required.',
            'slug.unique'      => 'This slug already exists.',
            'banner_image.image' => 'Only image files are allowed.',
            'banner_image.max'   => 'Image size must not exceed 2MB.',
        ];
    }
}
