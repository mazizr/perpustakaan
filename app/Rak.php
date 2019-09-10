<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Session;

class Rak extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_rak', 'nama_rak'
       ];
       public $timestamps = true;

       public function buku()
       {
           return $this->belongsToMany('App\Buku','rak_buku','rak_id','buku_id');
       }
}
