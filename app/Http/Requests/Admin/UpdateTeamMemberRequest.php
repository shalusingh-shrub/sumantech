<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage_team');
    }
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'designation' => ['nullable', 'string', 'max:255', 'regex:/^[^<>]*$/'],
            'department'  => ['nullable', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]*$/'],
            'email'       => ['nullable', 'email', 'max:255'],
            'about'       => ['nullable', 'string', 'max:2000'],
            'role_type'   => ['required', 'string', 'in:founder,co_founder,advisor,core_team,member,lecturer'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }
    public function attributes(): array
    {
        return [
            'name'        => 'Name',
            'designation' => 'Designation',
            'department'  => 'Department',
            'phone'       => 'Phone',
            'email'       => 'Email',
            'role_type'   => 'Role Type',
            'photo'       => 'Photo',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'      => 'Name is required.',
            'name.min'           => 'Name must be at least 3 characters.',
            'name.regex'         => 'Name cannot contain < > characters.',
            'designation.regex'  => 'Designation cannot contain < > characters.',
            'email.email'        => 'Email must be a valid email address.',
            'phone.regex'        => 'Phone number can only contain numbers.',
            'role_type.required' => 'Role Type is required.',
            'role_type.in'       => 'The selected Role Type is not valid.',
            'photo.image'        => 'Only image files are allowed.',
            'photo.mimes'        => 'Photo must be JPG, PNG or WebP format.',
            'photo.max'          => 'Photo size must not exceed 2MB.',
        ];
    }
}
