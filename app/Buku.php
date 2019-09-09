<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'kode_buku', 'judul', 'penulis', 'penerbit', 'tahun_terbit'
       ];

       public function rak()
        {
    	    return $this->hasMany('App\Rak', 'kode_buku');
        }

       public function peminjaman()
       {
           return $this->hasMany('App\Peminjaman', 'kode_buku');
       }

       public function pengembalian()
        {
    	    return $this->hasMany('App\Pengembalian', 'kode_buku');
        }
}
