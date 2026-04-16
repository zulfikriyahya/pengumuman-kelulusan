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
        Schema::create('personils', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('foto')->nullable();
            $table->string('telepon', 15)->nullable();
            $table->string('sosial_media')->nullable();
            $table->string('jabatan');
            $table->text('quote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personils');
    }
};
