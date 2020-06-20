<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
			$table->string('nip18', 30)->primary('pegawai_pkey');
			$table->string('nrk', 30)->nullable();
			$table->string('kolok', 20)->nullable();
			$table->string('pangkat', 20)->nullable();
			$table->string('eselon', 30)->nullable();
			$table->string('kd', 10)->nullable();
			$table->string('kojab', 20)->nullable();
			$table->string('jabatan', 200)->nullable();
			$table->string('status', 10)->nullable();
			$table->string('nip', 30)->nullable();
			$table->string('nama', 100)->nullable();
			$table->string('unit_kerja', 200)->nullable();
			$table->integer('max_point')->nullable();
			$table->integer('max_point_id')->nullable();
			$table->string('keterangan', 50)->nullable();
			$table->integer('job_value_1')->nullable();
			$table->integer('job_value_2')->nullable();
			$table->integer('job_value_3')->nullable();
			$table->integer('job_value_4')->nullable();
			$table->string('kojab_1', 20)->nullable();
			$table->string('kojab_2', 20)->nullable();
			$table->string('kojab_3', 20)->nullable();
			$table->string('kojab_4', 20)->nullable();
			$table->string('kolok_1', 20)->nullable();
			$table->string('kolok_2', 20)->nullable();
			$table->string('kolok_3', 20)->nullable();
			$table->string('kolok_4', 20)->nullable();
			$table->string('rekening_bank', 200)->nullable();
			$table->string('rekening_nomor', 200)->nullable();
			$table->string('subdin', 20)->nullable();
			$table->integer('urut')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
}
