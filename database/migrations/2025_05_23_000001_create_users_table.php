<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('google_id', 255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->string('role', 255)->default('user');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();

            $table->integer('umur')->nullable();
            $table->string('nomor_telepon', 15)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->text('riwayat_kesehatan')->nullable();
            $table->text('alergi')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
