<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }
    public function rules(): array {
        return [
            'name'         => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'designation'  => ['nullable', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'content'      => ['required', 'string', 'max:1000'],
            'rating'       => ['nullable', 'integer', 'min:1', 'max:5'],
            'photo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'    => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array {
        return [
            'name.required'    => 'Name is required.',
            'name.min'         => 'Name must be at least 3 characters.',
            'name.regex'       => 'Name cannot contain < > characters.',
            'content.required' => 'Content is required.',
            'content.max'      => 'Content must not exceed 1000 characters.',
            'rating.min'       => 'Rating must be between 1 and 5.',
            'rating.max'       => 'Rating must be between 1 and 5.',
            'photo.image'      => 'Only image files are allowed.',
            'photo.mimes'      => 'Photo must be JPG, PNG or WebP format.',
            'photo.max'        => 'Photo size must not exceed 2MB.',
        ];
    }
}
