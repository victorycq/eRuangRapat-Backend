<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFasilitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_ruangrapat');
            $table->foreign('id_ruangrapat')->references('id')->on('ruang_rapat');
            $table->integer('meja_pimpinan')->default(0)->nullable();
            $table->integer('podium')->default(0)->nullable();
            $table->integer('meja_peserta')->default(0)->nullable();
            $table->integer('kursi_peserta')->default(0)->nullable();
            $table->integer('microphone')->default(0)->nullable();
            $table->integer('papan_tulis')->default(0)->nullable();
            $table->integer('ruang_transit')->default(0)->nullable();
            $table->integer('ruang_makan')->default(0)->nullable();
            $table->integer('ac')->default(0)->nullable();
            $table->integer('lcd_tv')->default(0)->nullable();
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
        Schema::dropIfExists('fasilitas');
    }
}
