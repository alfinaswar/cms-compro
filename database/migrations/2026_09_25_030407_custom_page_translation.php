<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('custom_page_translation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('CustomPageId');
            $table->string('Locale', 10)->default('id');

            $table->string('Judul')->nullable();
            $table->text('DeskripsiSingkat')->nullable();
            $table->longText('Konten')->nullable();
            $table->string('SEOTitle', 70)->nullable();
            $table->text('SEODescription')->nullable();
            $table->string('SEOKeywords', 255)->nullable();

            $table->unique(['CustomPageId', 'Locale']);
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('CustomPageTranslations');
    }
};
