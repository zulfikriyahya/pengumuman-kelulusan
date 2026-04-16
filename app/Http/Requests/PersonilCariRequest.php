<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonilCariRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Masukkan nama personil yang ingin dicari.',
        ];
    }
}
