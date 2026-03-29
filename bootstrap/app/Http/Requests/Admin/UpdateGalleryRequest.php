<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage_gallery');
    }

    public function rules(): array
    {
        return [
            'title'     => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'type'      => ['required', 'string', 'in:image,video'],
            'category'  => ['nullable', 'string', 'max:100'],
            'image'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'     => 'Title',
            'type'      => 'Type',
            'category'  => 'Category',
            'image'     => 'Image',
            'video_url' => 'Video URL',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            'title.min'      => 'Title must be at least 3 characters.',
            'title.max'      => 'Title must not exceed 255 characters.',
            'title.regex'    => 'Title cannot contain < > characters.',
            'type.required'  => 'Type is required.',
            'type.in'        => 'Type must be either image or video.',
            'image.image'    => 'Only image files are allowed.',
            'image.mimes'    => 'Image must be JPG, PNG or WebP format.',
            'image.max'      => 'Image size must not exceed 2MB.',
            'video_url.url'  => 'Video URL must be a valid URL.',
        ];
    }
}
