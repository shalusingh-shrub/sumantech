<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMagazineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage_publications');
    }

    public function rules(): array
    {
        return [
            'title'                => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'magazine_category_id' => ['required', 'integer', 'exists:magazine_categories,id'],
            'magazine_date'        => ['required', 'date'],
            'description'          => ['nullable', 'string', 'max:1000'],
            'image'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file'                 => ['nullable', 'mimes:pdf', 'max:10240'],
            'is_active'            => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'                => 'Title',
            'magazine_category_id' => 'Magazine Type',
            'magazine_date'        => 'Magazine Date',
            'image'                => 'Cover Image',
            'file'                 => 'PDF File',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'                => 'Title is required.',
            'title.min'                     => 'Title must be at least 3 characters.',
            'title.max'                     => 'Title must not exceed 255 characters.',
            'title.regex'                   => 'Title cannot contain < > characters.',
            'magazine_category_id.required' => 'Magazine Type is required.',
            'magazine_category_id.exists'   => 'The selected Magazine Type is not valid.',
            'magazine_date.required'        => 'Magazine Date is required.',
            'magazine_date.date'            => 'Magazine Date must be a valid date.',
            'image.image'                   => 'Only image files are allowed.',
            'image.mimes'                   => 'Cover image must be JPG, PNG or WebP format.',
            'image.max'                     => 'Cover image must not exceed 2MB.',
            'file.mimes'                    => 'Only PDF files are allowed.',
            'file.max'                      => 'PDF file must not exceed 10MB.',
        ];
    }
}
