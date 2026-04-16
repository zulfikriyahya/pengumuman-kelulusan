<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TamuUndanganScanQrRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Hanya validasi siswa_id hasil scan QR
            'siswa_id' => ['required', 'uuid', 'exists:siswas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'siswa_id.required' => 'QR Code tidak terbaca.',
            'siswa_id.uuid'     => 'QR Code tidak valid.',
            'siswa_id.exists'   => 'Data siswa tidak ditemukan.',
        ];
    }
}
