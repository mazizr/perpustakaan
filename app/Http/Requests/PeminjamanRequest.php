<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PeminjamanRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'kode_pinjam' => 'required|max:4|unique:peminjamen,kode_pinjam,'.$request->peminjaman_id.',id',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
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
            'kode_pinjam.required' => 'Kode Pinjam wajib diisi',
            'kode_pinjam.unique' => 'Kode Pinjam telah terpakai',
            'kode_pinjam.max' => 'Kode Pinjam Maksimal 4 Karakter',
            'tanggal_pinjam.required' => 'Tanggal Pinjam Wajib Dipilih',
            'tanggal_kembali.required' => 'Tanggal Kembali Harus Dipilih',
            'kode_petugas.required' => 'Kode Petugas Wajib Dipilih',
            'kode_anggota.required' => 'Kode Anggota Wajib Dipilih',
            'kode_buku.required' => 'Kode Buku Wajib Dipilih'

        ];
    }
}

