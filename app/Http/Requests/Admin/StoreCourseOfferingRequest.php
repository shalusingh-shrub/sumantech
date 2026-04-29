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
            'course_id.required'      => 'Course select karna zaroori hai!',
            'duration_value.required' => 'Duration value zaroori hai!',
            'duration_value.min'      => 'Duration kam se kam 1 hona chahiye!',
            'duration_unit.required'  => 'Duration unit select karna zaroori hai!',
            'price.required'          => 'Price zaroori hai!',
            'price.min'               => 'Price 0 se kam nahi ho sakta!',
        ];
    }
}