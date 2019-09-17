<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class KodeRakStoreRequest extends FormRequest
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
            'kode_rak' => 'required|max:4',
            'nama_rak' => 'required',
            'buku' => 'required'
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
            'kode_rak.required' => 'Kode Rak wajib diisi',
            'kode_rak.unique' => 'Kode Rak telah terpakai',
            'kode_rak.max' => 'Kode Rak Maksimal 4 Karakter',
            'nama_rak.required' => 'Nama Rak Wajib Diisi!',
            'buku' => 'Judul Buku wajib Dipilih!'
        ];
    }
}
