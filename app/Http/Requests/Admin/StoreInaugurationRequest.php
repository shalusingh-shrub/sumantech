<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInaugurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();

        return $user && (
            $user->can('manage_inaugurations')
            || $user->hasRole(['super_admin', 'superadmin', 'admin'])
            || $user->role === 'admin'
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_enabled' => $this->boolean('is_enabled'),
            'paths' => $this->normalizePaths($this->input('paths')),
            'route_names' => array_values(array_filter((array) $this->input('route_names', []))),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255', 'regex:/^[^<>]*$/'],
            'message' => ['required', 'string', 'max:2000'],
            'poster' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'password' => ['required', 'string', 'min:3', 'max:100'],
            'is_enabled' => ['boolean'],
            'scope' => ['required', Rule::in(['all', 'selected'])],
            'message_position' => ['required', Rule::in(['top', 'middle', 'bottom'])],
            'content_align' => ['required', Rule::in(['left', 'center', 'right'])],
            'route_names' => ['nullable', 'array'],
            'route_names.*' => ['string', 'max:255'],
            'paths' => ['nullable', 'array'],
            'paths.*' => ['string', 'max:255'],
        ];
    }

    private function normalizePaths(mixed $paths): array
    {
        if (is_array($paths)) {
            return array_values(array_filter($paths));
        }

        return collect(preg_split('/\r\n|\r|\n/', (string) $paths))
            ->map(fn ($path) => trim($path))
            ->filter()
            ->values()
            ->all();
    }
}
