<?php

namespace App\Http\Requests\Admin;

class UpdateInaugurationRequest extends StoreInaugurationRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['poster'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'];
        $rules['password'] = ['nullable', 'string', 'min:3', 'max:100'];

        return $rules;
    }
}
