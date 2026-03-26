<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage_news');
    }

    protected function prepareForValidation(): void
    {
        if ($this->title) {
            $this->merge(['title' => trim($this->title)]);
        }
        if ($this->boolean('auto_slug') || empty($this->slug)) {
            $this->merge(['slug' => Str::slug($this->title) . '-' . time()]);
        } else {
            $this->merge(['slug' => Str::slug($this->slug)]);
        }
        if ($this->content) {
            $stripped = trim(strip_tags($this->content));
            if (empty($stripped)) {
                $this->merge(['content' => null]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'slug'             => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9-]+$/', 'unique:news_events,slug'],
            'content'          => ['required', 'string', new \App\Rules\MaxWords(1000)],
            'excerpt'          => ['nullable', 'string', 'max:500', 'regex:/^[^<>]*$/'],
            'news_category_id' => ['nullable', 'integer', 'exists:news_categories,id'],
            'news_type'        => ['required', 'string', 'in:news,event'],
            'event_date'       => ['nullable', 'date', 'required_if:news_type,event'],
            'publish_date'     => ['nullable', 'date'],
            'status'           => ['required', 'string', 'in:active,inactive'],
            'pin_to_home'      => ['required', 'string', 'in:yes,no'],
            'image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords'    => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'            => 'Title',
            'slug'             => 'Slug',
            'content'          => 'Content',
            'excerpt'          => 'Excerpt',
            'news_category_id' => 'Category',
            'news_type'        => 'News Type',
            'event_date'       => 'Event Date',
            'publish_date'     => 'Publish Date',
            'status'           => 'Status',
            'pin_to_home'      => 'Pin to Home',
            'image'            => 'Featured Image',
            'meta_title'       => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords'    => 'Meta Keywords',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'         => 'Title is required.',
            'title.min'              => 'Title must be at least 3 characters.',
            'title.max'              => 'Title must not exceed 255 characters.',
            'title.regex'            => 'Title cannot contain < > characters.',
            'slug.unique'            => 'This slug already exists.',
            'slug.regex'             => 'Slug can only contain lowercase letters, numbers and hyphens.',
            'content.required'       => 'Content is required.',
            'excerpt.regex'          => 'Excerpt cannot contain < > characters.',
            'news_type.required'     => 'News Type is required.',
            'event_date.required_if' => 'Event Date is required when type is event.',
            'status.required'        => 'Status is required.',
            'pin_to_home.required'   => 'Pin to Home is required.',
            'image.image'            => 'Only image files are allowed.',
            'image.mimes'            => 'Image must be JPG, PNG or WebP format.',
            'image.max'              => 'Image size must not exceed 2MB.',
        ];
    }
}
