<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Buku extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'kode_buku', 'judul', 'penulis', 'penerbit', 'tahun_terbit'
       ];
       public $timestamps = true;

       public function rak()
       {
           return $this->belongsToMany('App\Rak','rak_buku','buku_id','rak_id');
       }

       public function peminjaman()
       {
           return $this->belongsToMany('App\Peminjaman','peminjaman_buku','id_buku','id_peminjaman');
       }

       public function pengembalian()
        {
    	    return $this->hasMany('App\Pengembalian', 'kode_buku');
        }

}
