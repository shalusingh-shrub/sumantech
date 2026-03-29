<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompetitionRequest extends FormRequest {
    public function authorize(): bool { return auth()->check() && auth()->user()->can('manage_competitions'); }
    public function rules(): array {
        return [
            'title'                       => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^<>]*$/'],
            'description'                 => ['nullable', 'string'],
            'start_date'                  => ['required', 'date'],
            'end_date'                    => ['required', 'date', 'after_or_equal:start_date'],
            'result_date'                 => ['nullable', 'date'],
            'registration_link'           => ['nullable', 'url', 'max:500'],
            'event_selection_category'    => ['nullable', 'string'],
            'participation_category'      => ['nullable', 'string'],
            'image'                       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'winner_certificate'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'participation_certificate'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'audience_certificate'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_participation_cert_allow' => ['nullable', 'boolean'],
            'is_auto_gen_certificate'     => ['nullable', 'boolean'],
            'is_active'                   => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array {
        return [
            'title.required'          => 'Title is required.',
            'start_date.required'     => 'Start Date is required.',
            'end_date.required'       => 'End Date is required.',
            'end_date.after_or_equal' => 'End Date must be after Start Date.',
        ];
    }
}
