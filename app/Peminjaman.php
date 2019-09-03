<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $fillable = [
        'kode_peminjaman', 'tanggal_pinjam', 'tanggal_kembali', 'kode_petugas', 'kode_anggota', 'kode_buku'
       ];

       public function petugas()
       {
           return $this->belongsTo('App\Petugas');
       }

       public function anggota()
       {
           return $this->belongsTo('App\Anggota');
       }

       public function buku()
       {
           return $this->belongsTo('App\Buku');
       }

}
