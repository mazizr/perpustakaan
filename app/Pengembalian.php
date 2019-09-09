<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Pengembalian extends Model
{
    protected $fillable = [
        'kode_kembali', 'tanggal_kembali', 'jatuh_tempo', 'denda_per_hari', 'jumlah_hari', 
        'total_denda', 'kode_petugas', 'kode_anggota', 'kode_buku'
       ];

       public function petugas()
       {
           return $this->belongsTo('App\Petugas', 'kode_petugas');
       }

       public function anggota()
       {
           return $this->belongsTo('App\Anggota', 'kode_anggota');
       }

       public function buku()
       {
           return $this->belongsTo('App\Buku', 'kode_buku');
       }
}
