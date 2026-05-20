<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetOtpsTable extends Migration
{
    public function up()
    {
        Schema::create('password_reset_otps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 255);
            $table->string('otp', 255);
            $table->boolean('used')->default(false);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->index('email');
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_reset_otps');
    }
}
