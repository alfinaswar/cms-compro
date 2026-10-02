<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('berita_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('BeritaId')->constrained('beritas')->cascadeOnDelete();
            $table->string('Locale', 10)->default('id');
            $table->string('Judul');
            $table->text('Ringkasan')->nullable();
            $table->longText('Konten')->nullable();
            $table->string('SEOTitle')->nullable();
            $table->text('SEODescription')->nullable();
            $table->string('SEOKeywords')->nullable();
            $table->unique(['BeritaId', 'Locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_translations');
    }
};
