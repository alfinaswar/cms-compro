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
        Schema::create('lowongan_kerja_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('LowonganKerjaId')->constrained('lowongan_kerjas')->cascadeOnDelete();
            $table->string('Locale', 10)->default('id');
            $table->string('Posisi')->nullable();
            $table->text('Deskripsi')->nullable();
            $table->longText('Kualifikasi')->nullable();
            $table->unique(['LowonganKerjaId', 'Locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan_kerja_translations');
    }
};
