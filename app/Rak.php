<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Rak extends Model
{
    protected $fillable = [
        'kode_rak', 'nama_rak', 'kode_buku'
       ];

       public function buku()
       {
           return $this->belongsTo('App\Buku', 'kode_buku');
       }
}
