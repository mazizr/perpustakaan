<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToPengembalians extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petugas', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('anggotas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('bukus', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('raks', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('peminjamen', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('pengembalians', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petugas', function (Blueprint $table) {
            //
        });

        Schema::table('anggotas', function (Blueprint $table) {
            //
        });

        Schema::table('bukus', function (Blueprint $table) {
            //
        });

        Schema::table('raks', function (Blueprint $table) {
            //
        });

        Schema::table('peminjamen', function (Blueprint $table) {
            //
        });

        Schema::table('pengembalians', function (Blueprint $table) {
            //
        });
    }
}
