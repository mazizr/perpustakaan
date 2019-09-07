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
    	    return $this->hasOne('App\Rak', 'kode_buku');
        }

       public function peminjaman()
       {
           return $this->hasOne('App\Peminjaman', 'kode_buku');
       }

       public function pengembalian()
        {
    	    return $this->hasOne('App\Pengembalian', 'kode_buku');
        }
}
