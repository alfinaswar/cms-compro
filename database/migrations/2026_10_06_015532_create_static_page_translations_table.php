<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('static_page_translation', function (Blueprint $table) {
            $table->id();
            $table->string('StaticPageId');
            $table->string('Locale', 5); // id, en
            $table->string('Judul');
            $table->longText('Konten')->nullable();
            $table->string('SEOTitle')->nullable();
            $table->string('SEODescription', 160)->nullable();
            $table->string('SEOKeywords')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('StaticPageTranslations');
    }
};
