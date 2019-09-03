<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = [
        'kode_kembali', 'tanggal_kembali', 'jatuh_tempo', 'denda_per_hari', 'jumlah_hari', 
        'total_denda', 'kode_petugas', 'kode_anggota', 'kode_buku'
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
