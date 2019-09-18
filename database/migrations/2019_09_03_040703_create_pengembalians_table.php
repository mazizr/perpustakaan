<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengembaliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('kode_kembali');
            $table->date('tanggal_kembali');
            $table->date('jatuh_tempo');
            $table->double('denda_per_hari');
            $table->integer('jumlah_hari');
            $table->double('total_denda');
            $table->unsignedBigInteger('kode_petugas');
            $table->unsignedBigInteger('kode_anggota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalians');
    }
}
