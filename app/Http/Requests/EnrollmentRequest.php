<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'course_offering_id' => 'required|exists:course_offerings,id',
        ];
    }

    public function messages(): array
    {
        return [
            'course_offering_id.required' => 'Please select a course offering.',
            'course_offering_id.exists'   => 'The selected course offering does not exist.',
        ];
    }
}