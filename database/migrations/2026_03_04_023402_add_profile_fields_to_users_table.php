<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dulu, kalau kolom 'phone' belum ada, baru buat
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }

            // Cek juga buat 'alamat'
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable();
            }

            // Cek juga buat 'avatar'
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
