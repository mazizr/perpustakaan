<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengembalianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode_kembali' => 'required|max:4',
            'kode_pinjam' => 'required',
            'jatuh_tempo' => 'required',
            'kode_petugas' => 'required',
            'kode_anggota' => 'required',
            'kode_buku' => 'required'
        ];
    }
     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'kode_kembali.required' => 'Kode Pinjam wajib diisi',
            'kode_kembali.max' => 'Kode Pinjam Maksimal 4 Karakter',
            'kode_pinjam.required' => 'Kode Pinjam wajib Dipilih',
            'jatuh_tempo.required' => 'Jatuh Tempo Wajib Dipilih',
            'kode_petugas.required' => 'Kode Petugas Wajib Dipilih',
            'kode_anggota.required' => 'Kode Anggota Wajib Dipilih',
            'kode_buku.required' => 'Kode Buku Wajib Dipilih'

        ];
    }
}
