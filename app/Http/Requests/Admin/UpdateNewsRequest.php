<?php
// File: app/Http/Requests/Admin/UpdateNewsRequest.php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateNewsRequest extends FormRequest
{
    /**
     * Only users with manage_news permission can update
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage_news');
    }

    /**
     * Prepare data automatically before validation
     */
    protected function prepareForValidation(): void
    {
        // Trim the title
        if ($this->title) {
            $this->merge(['title' => trim($this->title)]);
        }

        // Auto-generate the slug (use current news ID as suffix during update)
        if ($this->boolean('auto_slug') || empty($this->slug)) {
            $this->merge(['slug' => Str::slug($this->title) . '-' . $this->route('news')->id]);
        } else {
            $this->merge(['slug' => Str::slug($this->slug)]);
        }

        // CKEditor empty content check
        if ($this->content) {
            $stripped = trim(strip_tags($this->content));
            if (empty($stripped)) {
                $this->merge(['content' => null]);
            }
        }
    }

    /**
     * Validation rules for updates
     * Ignore the current record ID during the unique slug check
     */
    public function rules(): array
    {
        // Get the current news ID from the route
        $newsId = $this->route('news')->id;

        return [
            'title'            => ['required', 'string', 'min:3', 'max:255'],
            'slug'             => ['required', 'string', 'max:255', 'unique:news_events,slug,' . $newsId],
            'content'          => ['required', 'string', new \App\Rules\MaxWords(1000)],
            'excerpt'          => ['nullable', 'string', 'max:500'],
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

    /**
     * Human-readable field names
     */
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

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'title.required'           => 'Title is required.',
            'title.min'                => 'Title must be at least 3 characters.',
            'title.max'                => 'Title must not exceed 255 characters.',
            'slug.required'            => 'Slug could not be generated, please re-enter the title.',
            'slug.unique'              => 'This slug already exists.',
            'content.required'         => 'Content is required, please write something.',
            'excerpt.max'              => 'Excerpt must not exceed 500 characters.',
            'news_category_id.exists'  => 'The selected category is not valid.',
            'news_type.required'       => 'News Type is required.',
            'news_type.in'             => 'News Type must be either news or event.',
            'event_date.required_if'   => 'Event date is required when event type is selected.',
            'event_date.date'          => 'Event Date must be a valid date.',
            'publish_date.date'        => 'Publish Date must be a valid date.',
            'status.required'          => 'Status is required.',
            'status.in'                => 'Status must be either active or inactive.',
            'pin_to_home.required'     => 'Pin to Home is required.',
            'pin_to_home.in'           => 'Pin to Home must be either yes or no.',
            'image.image'              => 'Only image files are allowed.',
            'image.mimes'              => 'Image must be JPG, JPEG, PNG or WebP format.',
            'image.max'                => 'Image size must not exceed 2MB.',
            'meta_title.max'           => 'Meta Title must not exceed 255 characters.',
            'meta_description.max'     => 'Meta Description must not exceed 500 characters.',
            'meta_keywords.max'        => 'Meta Keywords must not exceed 255 characters.',
        ];
    }
}
