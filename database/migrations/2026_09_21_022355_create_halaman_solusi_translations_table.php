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
        Schema::create('halaman_solusi_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('halaman_solusi_id');
            $table->string('Locale', 10)->default('id');

            $table->string('Judul')->nullable();
            $table->text('DeskripsiSingkat')->nullable();
            $table->longText('Konten')->nullable();
            $table->string('SEOTitle', 70)->nullable();
            $table->text('SEODescription')->nullable();
            $table->string('SEOKeywords', 255)->nullable();

            $table->unique(['halaman_solusi_id', 'Locale']);
            $table->timestamps();

            $table->foreign('halaman_solusi_id')->references('id')->on('halaman_solusis')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halaman_solusi_translations');
    }
};
