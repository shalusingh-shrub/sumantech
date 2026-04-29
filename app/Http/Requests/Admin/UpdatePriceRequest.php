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
            'price.required' => 'Naya price zaroori hai!',
            'price.min'      => 'Price 0 se kam nahi ho sakta!',
        ];
    }
}