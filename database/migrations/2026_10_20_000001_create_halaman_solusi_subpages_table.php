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
        // Jangan jalankan kalau tabel sudah ada
        if (Schema::hasTable('halaman_solusi_subpages')) {
            return;
        }

        Schema::create('halaman_solusi_subpages', function (Blueprint $table) {
            $table->id();
            // Relasi 1:1 ke detail solusi (row yang punya tombol "Subhalaman")
            $table->unsignedBigInteger('HalamanSolusiDetailId')->unique();

            // === HERO ===
            $table->string('Judul')->nullable();           // Judul Halaman (hero besar)
            $table->string('SubJudul')->nullable();        // Sub Judul di hero
            $table->text('Deskripsi')->nullable();         // Deskripsi hero
            $table->longText('Konten')->nullable();        // Konten utama (rich text, opsional)
            $table->string('Slug')->nullable();
            $table->string('GambarHero')->nullable();
            $table->boolean('IsPublished')->default(true);

            // === SECTION 1 (Komponen) ===
            $table->string('Sec1SubJudul')->nullable();    // badge/subjudul section
            $table->string('Sec1Judul')->nullable();
            $table->text('Sec1Deskripsi')->nullable();

            // === SECTION 2 (Solusi / keunggulan) ===
            $table->string('Sec2SubJudul')->nullable();
            $table->string('Sec2Judul')->nullable();
            $table->text('Sec2Deskripsi')->nullable();

            // === SECTION 3 (Keamanan) ===
            $table->string('Sec3SubJudul')->nullable();
            $table->string('Sec3Judul')->nullable();
            $table->text('Sec3Deskripsi')->nullable();

            // === FAQ ===
            $table->string('FaqSubJudul')->nullable();
            $table->string('FaqJudul')->nullable();
            $table->text('FaqDeskripsi')->nullable();

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('HalamanSolusiDetailId')
                ->references('id')->on('halaman_solusi_details')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('halaman_solusi_subpages')) {
            return;
        }
        Schema::dropIfExists('halaman_solusi_subpages');
    }
};
