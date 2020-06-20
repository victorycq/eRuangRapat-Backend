<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_eruangrapat', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('username');
            $table->string('password');
            $table->string('email')->unique()->nullable();
            $table->string('role_id')->references('id')->on('role');;
            $table->string('nip')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->dateTime('delete_at')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->dateTime('dob')->nullable();
            $table->string('opd')->nullable();
            $table->string('user_name');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
