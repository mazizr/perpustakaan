<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $fillable = [
        'kode_petugas', 'nama', 'jk', 'jabatan', 'telepon', 'alamat'
       ];

       public function peminjaman()
       {
           return $this->hasMany('App\Peminjaman', 'kode_petugas');
       }

       public function pengembalian()
        {
    	    return $this->hasMany('App\Pengembalian', 'kode_petugas');
        }
}
