<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Anggota extends Model
{
    use SoftDeletes;

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
