<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage_sliders');
    }
    public function rules(): array
    {
        return [
            'title'      => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'link'       => ['nullable', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image'      => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }
    public function attributes(): array
    {
        return ['title' => 'Title', 'link' => 'Link', 'image' => 'Image', 'sort_order' => 'Sort Order'];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            'title.min'      => 'Title must be at least 3 characters.',
            'title.regex'    => 'Title cannot contain < > characters.',
            'image.required' => 'Slider image is required.',
            'image.image'    => 'Only image files are allowed.',
            'image.mimes'    => 'Image must be JPG, PNG or WebP format.',
            'image.max'      => 'Image size must not exceed 2MB.',
            'link.url'       => 'Link must be a valid URL.',
        ];
    }
}
