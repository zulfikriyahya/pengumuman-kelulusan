<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tahun_pelajarans', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->dateTime('jadwal_pengumuman_mulai');
            $table->dateTime('jadwal_pengumuman_selesai');
            $table->dateTime('jadwal_kelulusan_mulai')->nullable();
            $table->dateTime('jadwal_kelulusan_selesai')->nullable();
            $table->string('jadwal_kelulusan_tempat')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_pelajarans');
    }
};
