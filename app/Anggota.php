<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Anggota extends Model
{
    protected $fillable = [
        'kode_anggota', 'nama', 'jk', 'jurusan', 'alamat'
       ];

       public function peminjaman()
       {
           return $this->hasMany('App\Peminjaman', 'kode_anggota');
       }

       public function pengembalian()
        {
    	    return $this->hasMany('App\Pengembalian', 'kode_anggota');
        }
}
