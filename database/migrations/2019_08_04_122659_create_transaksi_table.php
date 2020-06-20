<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date_order');
            $table->integer('id_lokasi');
            $table->string('nip_pj')->nullable();
            $table->integer('waktu_id');
            $table->dateTime('start');
            $table->dateTime('finish');
            $table->text('keterangan')->nullable();
            $table->string('file_permohonan')->nullable();
            $table->string('file_undangan')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('delete')->nullable();
            $table->string('judul_rapat')->nullable();
            $table->string('pimpinan_rapat')->nullable();
            $table->string('nip_pimpinan')->nullable();
            $table->string('nip_notulen')->nullable();
            $table->string('opd_peminjam')->nullable();
            $table->string('nama_peminjam')->nullable();
            $table->string('nip_pemesan')->nullable();
            $table->timestamps();
            $table->integer('id_user')->nullable()->unsigned();
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
