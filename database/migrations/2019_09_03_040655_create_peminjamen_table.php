<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeminjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('kode_pinjam');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->unsignedBigInteger('kode_petugas');
            $table->unsignedBigInteger('kode_anggota');
            $table->timestamps();
        });

        Schema::create('peminjaman_buku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('id_buku');
            $table->unsignedInteger('id_peminjaman');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjamen');
        Schema::dropIfExists('peminjaman_buku');
    }
}
