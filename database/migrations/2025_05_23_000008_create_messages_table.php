<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_id');
            $table->unsignedBigInteger('to_id')->nullable();
            $table->string('to_role', 255)->nullable();
            $table->text('message');
            $table->timestamps();

            $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('from_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
