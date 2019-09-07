<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = [
        'kode_anggota', 'nama', 'jk', 'jurusan', 'alamat'
       ];

       public function peminjaman()
       {
           return $this->hasOne('App\Peminjaman', 'kode_anggota');
       }

       public function pengembalian()
        {
    	    return $this->hasOne('App\Pengembalian', 'kode_anggota');
        }
}
