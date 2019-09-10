<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBukusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('kode_buku');
            $table->String('judul');
            $table->String('penulis');
            $table->String('penerbit');
            $table->date('tahun_terbit');
            $table->timestamps();
        });

        Schema::create('rak_buku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('buku_id');
            $table->unsignedInteger('rak_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bukus');
        Schema::dropIfExists('rak_buku');
    }
}
