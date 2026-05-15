<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'price.required' => 'New price is required.',
            'price.min'      => 'Price cannot be less than 0.',
        ];
    }
}