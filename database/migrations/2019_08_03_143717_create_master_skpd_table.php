<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterSkpdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_skpd', function (Blueprint $table) {
			$table->string('kode_skpd', 30)->primary('master_skpd_pkey1')->nullable();
			$table->string('nama_skpd', 300)->nullable();
			$table->string('unit_id', 30)->nullable();
			$table->integer('jumlevel')->nullable();
			$table->string('level1', 40)->nullable();
			$table->string('level2', 40)->nullable();
			$table->string('level3', 40)->nullable();
			$table->string('level4', 40)->nullable();
			$table->string('variasi', 4)->nullable();
			$table->string('triwulan1', 30)->nullable();
			$table->string('triwulan2', 30)->nullable();
			$table->string('triwulan3', 30)->nullable();
			$table->string('triwulan4', 30)->nullable();
			$table->float('anggaran_1', 10, 0)->nullable()->default(0);
			$table->float('anggaran_2', 10, 0)->nullable()->default(0);
			$table->float('anggaran_3', 10, 0)->nullable()->default(0);
			$table->float('anggaran_4', 10, 0)->nullable()->default(0);
			$table->float('anggaran_5', 10, 0)->nullable()->default(0);
			$table->float('anggaran_6', 10, 0)->nullable()->default(0);
			$table->float('anggaran_7', 10, 0)->nullable()->default(0);
			$table->float('anggaran_8', 10, 0)->nullable()->default(0);
			$table->float('anggaran_9', 10, 0)->nullable()->default(0);
			$table->float('anggaran_10', 10, 0)->nullable()->default(0);
			$table->float('anggaran_11', 10, 0)->nullable()->default(0);
			$table->float('anggaran_12', 10, 0)->nullable()->default(0);
			$table->string('verif', 40)->nullable();
			$table->integer('id');
			$table->boolean('edit_absen')->nullable()->default(0);
			$table->string('kepala_nip')->nullable();
			$table->string('kepala_nama')->nullable();
			$table->string('kepala_pangkat')->nullable();
			$table->string('kepala_jabatan')->nullable();
			$table->string('bendahara_nip')->nullable();
			$table->string('bendahara_nama')->nullable();
			$table->string('bendahara_pangkat')->nullable();
			$table->string('bendahara_jabatan')->nullable();
			$table->string('unit_id2')->nullable();
			$table->string('kode_kegiatan_kadis', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_skpds');
    }
}
