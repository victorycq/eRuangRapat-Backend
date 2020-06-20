<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuangRapatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruang_rapat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama',50);
            $table->string('lokasi',50);
            $table->string('opd',50);
            $table->integer('kapasitas');
            $table->string('keterangan')->nullable();
            $table->string('kooor_x')->nullable();
            $table->string('koor_y')->nullable();
            $table->string('contact');            
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
        Schema::dropIfExists('ruang_rapats');
    }
}
