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
           return $this->hasOne('App\Peminjaman', 'kode_petugas');
       }

       public function pengembalian()
        {
    	    return $this->hasOne('App\Pengembalian', 'kode_petugas');
        }
}
