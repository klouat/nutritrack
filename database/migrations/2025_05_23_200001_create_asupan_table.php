<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsupanTable extends Migration
{
    public function up()
    {
        Schema::create('asupan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('nama', 255);
            $table->decimal('kadar_gula', 6, 2);    
            $table->decimal('kadar_kalori', 6, 2);   
            $table->date('tanggal_konsumsi');
            $table->string('waktu_konsumsi', 255);
            $table->string('catatan', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asupan');
    }
}
