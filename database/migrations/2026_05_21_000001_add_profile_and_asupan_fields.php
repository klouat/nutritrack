<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'foto_profil')) {
                $table->string('foto_profil')->nullable()->after('alergi');
            }
        });

        Schema::table('asupan', function (Blueprint $table) {
            if (!Schema::hasColumn('asupan', 'porsi')) {
                $table->decimal('porsi', 8, 2)->default(1)->after('nama');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'foto_profil')) {
                $table->dropColumn('foto_profil');
            }
        });

        Schema::table('asupan', function (Blueprint $table) {
            if (Schema::hasColumn('asupan', 'porsi')) {
                $table->dropColumn('porsi');
            }
        });
    }
};
