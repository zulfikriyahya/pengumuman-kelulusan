<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request umum untuk semua halaman pencarian publik.
 *
 * Menggantikan: AlumnusCariRequest, PersonilCariRequest, LandingPageCariRequest
 */
class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q'       => ['nullable', 'string', 'max:255'],
            'nama'    => ['nullable', 'string', 'max:255'],
            'nisn'    => ['nullable', 'string', 'max:10'],
            'telepon' => ['nullable', 'string', 'max:15'],
        ];
    }

    /**
     * Setidaknya satu field pencarian harus diisi.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            if (! $this->anyFilled(['q', 'nama', 'nisn', 'telepon'])) {
                $v->errors()->add('q', 'Masukkan kata kunci pencarian.');
            }
        });
    }

    /**
     * Kembalikan keyword tunggal dari field manapun yang terisi.
     */
    public function keyword(): string
    {
        return $this->input('nisn')
            ?? $this->input('telepon')
            ?? $this->input('nama')
            ?? $this->input('q')
            ?? '';
    }
}
