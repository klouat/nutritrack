<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilihanSehatTable extends Migration
{
    public function up()
    {
        Schema::create('pilihan_sehat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul', 255);
            $table->string('kategori', 255);
            $table->string('gambar_path', 255);
            $table->string('nama', 255);
            $table->text('deskripsi');
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pilihan_sehat');
    }
}
