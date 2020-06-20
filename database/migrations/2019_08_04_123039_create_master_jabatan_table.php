<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_jabatan', function (Blueprint $table) {
			$table->string('kolok', 20);
			$table->string('kojab', 20);
			$table->integer('kdsort')->nullable();
			$table->string('nama_jabatan', 300)->nullable();
			$table->string('eselon', 10)->nullable();
			$table->string('kelas_jabatan', 5)->nullable();
			$table->integer('nilai_jabatan')->nullable();
			$table->integer('level')->nullable();
			$table->string('atasan', 20)->nullable();
			$table->string('nama_pejabat', 200)->nullable();
			$table->string('nip_pejabat', 40)->nullable();
			$table->integer('id');
			$table->primary(['kolok', 'kojab'], 'master_jabatan_pkey');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_jabatan');
    }
}
