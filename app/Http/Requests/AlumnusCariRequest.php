<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumnusCariRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Pencarian by nama (like) atau nisn (exact) — salah satu wajib diisi
            'nama' => ['required_without:nisn', 'nullable', 'string', 'max:255'],
            'nisn' => ['required_without:nama', 'nullable', 'string', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required_without' => 'Masukkan nama atau NISN alumni.',
            'nisn.required_without' => 'Masukkan nama atau NISN alumni.',
        ];
    }
}
