<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotulenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notulen', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->integer('lokasi');
            $table->string('perihal')->nullable();
            $table->dateTime('waktu_start');
            $table->dateTime('waktu_finish');
            $table->string('nip_pimpinan', 30);
            $table->string('nama_pimpinan', 100);
            $table->string('nip_notulen', 30);
            $table->string('nama_notulen', 100);
            $table->string('nip_sekertaris')->nullable();
            $table->string('nama_sekertaris')->nullable();
            $table->string('file_pendukung')->nullable();
            $table->longtext('kata_pembuka')->nullable();
            $table->longtext('peraturan')->nullable();
            $table->string('hasil_rapat')->nullable();
            $table->string('status');
            $table->string('token')->nullable();
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
        Schema::dropIfExists('notulens');
    }
}
