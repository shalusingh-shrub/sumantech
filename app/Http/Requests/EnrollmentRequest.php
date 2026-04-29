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
            'course_offering_id.required' => 'Course offering select karna zaroori hai!',
            'course_offering_id.exists'   => 'Selected course offering exist nahi karta!',
        ];
    }
}