<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseOfferingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id'      => 'required|exists:courses,id',
            'duration_value' => 'required|integer|min:1',
            'duration_unit'  => 'required|in:days,weeks,months,years',
            'price'          => 'required|numeric|min:0',
            'is_active'      => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'course_id.required'      => 'Please select a course.',
            'duration_value.required' => 'Duration value is required.',
            'duration_value.min'      => 'Duration must be at least 1.',
            'duration_unit.required'  => 'Please select a duration unit.',
            'price.required'          => 'Price is required.',
            'price.min'               => 'Price cannot be less than 0.',
        ];
    }
}