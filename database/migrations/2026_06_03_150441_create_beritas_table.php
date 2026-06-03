<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            // === KONTEN & KLASIFIKASI ===
            $table->string('Judul');
            $table->string('Slug')->unique();
            $table->string('Kategori')->nullable();  // Bisa diganti relasi jika ada tabel kategori
            $table->string('Tags')->nullable();  // Disimpan sebagai string (comma separated)
            $table->text('Ringkasan')->nullable();
            $table->longText('Konten')->nullable();
            // === MEDIA ===
            $table->string('PathThumbnail')->nullable();
            // === PUBLIKASI ===
            $table->enum('Status', ['Draf', 'Diterbitkan', 'Arsip'])->default('Draf');
            $table->dateTime('TanggalPublikasi')->nullable();
            $table->string('Penulis')->nullable();
            // === SEO ===
            $table->string('SEOTitle', 70)->nullable();
            $table->text('SEODescription')->nullable();
            $table->string('SEOKeywords', 255)->nullable();
            // === AUDIT TRAIL ===
            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
