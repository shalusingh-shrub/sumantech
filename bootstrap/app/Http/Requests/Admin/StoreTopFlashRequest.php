<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StoreTopFlashRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage_top_flash');
    }
    public function rules(): array
    {
        return [
            'title'      => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'link'       => ['nullable', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_new'     => ['nullable', 'boolean'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }
    public function attributes(): array
    {
        return ['title' => 'Title', 'link' => 'Link', 'sort_order' => 'Sort Order'];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            'title.min'      => 'Title must be at least 3 characters.',
            'title.regex'    => 'Title cannot contain < > characters.',
            'link.url'       => 'Link must be a valid URL.',
        ];
    }
}
