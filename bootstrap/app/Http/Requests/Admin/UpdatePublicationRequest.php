<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePublicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage_publications');
    }
    public function rules(): array
    {
        return [
            'title'          => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'category'       => ['required', 'string', 'in:science_corner,tlm,anusandhaanam,abhimat,emagazine,karmana,balman,suvichar,eresources,balmanch,shabdkosh,gyandrishti,other'],
            'description'    => ['nullable', 'string', 'max:2000'],
            'issue_number'   => ['nullable', 'string', 'max:50'],
            'published_date' => ['nullable', 'date'],
            'cover_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file'           => ['nullable', 'mimes:pdf', 'max:10240'],
            'is_active'      => ['nullable', 'boolean'],
        ];
    }
    public function attributes(): array
    {
        return [
            'title'          => 'Title',
            'category'       => 'Category',
            'issue_number'   => 'Issue Number',
            'published_date' => 'Published Date',
            'cover_image'    => 'Cover Image',
            'file'           => 'PDF File',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required'      => 'Title is required.',
            'title.min'           => 'Title must be at least 3 characters.',
            'title.regex'         => 'Title cannot contain < > characters.',
            'category.required'   => 'Category is required.',
            'category.in'         => 'The selected category is not valid.',
            'published_date.date' => 'Published Date must be a valid date.',
            'cover_image.image'   => 'Only image files are allowed.',
            'cover_image.mimes'   => 'Cover image must be JPG, PNG or WebP format.',
            'cover_image.max'     => 'Cover image must not exceed 2MB.',
            'file.mimes'          => 'Only PDF files are allowed.',
            'file.max'            => 'PDF file must not exceed 10MB.',
        ];
    }
}
