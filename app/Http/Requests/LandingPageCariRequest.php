<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LandingPageCariRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // User cukup isi salah satu: nisn atau telepon
            'nisn' => ['required_without:telepon', 'nullable', 'string', 'max:10'],
            'telepon' => ['required_without:nisn', 'nullable', 'string', 'max:15'],
        ];
    }

    public function messages(): array
    {
        return [
            'nisn.required_without'     => 'Masukkan NISN atau nomor telepon.',
            'telepon.required_without'  => 'Masukkan NISN atau nomor telepon.',
        ];
    }

    // Kembalikan keyword tunggal yang diisi user
    public function keyword(): string
    {
        return $this->filled('nisn') ? $this->nisn : $this->telepon;
    }
}
