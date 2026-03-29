<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAwardRequest extends FormRequest {
    public function authorize(): bool { return auth()->check() && auth()->user()->can('manage_awards'); }
    public function rules(): array {
        return [
            'title'                => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'description'          => ['nullable', 'string', 'max:2000'],
            'year'                 => ['nullable', 'digits:4', 'integer', 'min:2000', 'max:2099'],
            'image'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'certificate_template' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'has_certificate'      => ['nullable', 'boolean'],
            'is_active'            => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array {
        return [
            'title.required'                => 'Title is required.',
            'title.min'                     => 'Title must be at least 3 characters.',
            'title.regex'                   => 'Title cannot contain < > characters.',
            'year.digits'                   => 'Year must be 4 digits.',
            'certificate_template.image'    => 'Certificate must be an image file.',
            'certificate_template.mimes'    => 'Certificate must be JPG, PNG or WebP format.',
            'certificate_template.max'      => 'Certificate size must not exceed 5MB.',
        ];
    }
}
