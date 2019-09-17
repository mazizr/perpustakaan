<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PetugasRequest extends FormRequest
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
            'kode_petugas' => 'required|max:4|unique:petugas,kode_petugas,'.$request->petugas_id.',id',
            'nama' => 'required',
            'jk' => 'required',
            'jabatan' => 'required',
            'telepon' => 'required|numeric',
            'alamat' => 'required'
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
            'kode_petugas.required' => 'Kode Rak wajib diisi',
            'kode_petugas.unique' => 'Kode Petugas telah terpakai',
            'kode_petugas.max' => 'Kode Rak Maksimal 4 Karakter',
            'nama.required' => 'Nama Wajib Diisi',
            'jk.required' => 'Jenis Kelamin Harus Dipilih',
            'jabatan.required' => 'Jabatan Wajib Diisi',
            'telepon.required' => 'Telepon Wajib Diisi',
            'telepon.numeric' => 'Telepon Harus Berupa Angka',
            'alamat.required' => 'Alamat Wajib Diisi'

        ];
    }
}
