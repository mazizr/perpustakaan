<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Buku;

class BukuRequest extends FormRequest
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
            'kode_buku' => 'required|max:4|unique:bukus,kode_buku,'.$request->buku_id.',id',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required'
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
            'kode_buku.required' => 'Kode Buku wajib diisi',
            'kode_buku.unique' => 'Kode Buku telah terpakai',
            'kode_buku.max' => 'Kode Buku Maksimal 4 Karakter',
            'judul.required' => 'Judul Wajib Diisi',
            'penulis.required' => 'Penulis Harus Dipilih',
            'penerbit.required' => 'Penerbit Wajib Diisi',
            'tahun_terbit.required' => 'Tahun terbit Wajib Diisi'

        ];
    }
}

