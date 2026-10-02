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
        Schema::create('halaman_solusis', function (Blueprint $table) {
            $table->id();
            $table->string('Judul')->nullable();
            $table->string('Slug')->unique()->nullable();
            $table->string('DeskripsiSingkat')->nullable();
            $table->string('Thumbnail')->nullable();
            $table->text('Konten')->nullable();
            // FSEO
            $table->string('SEOTitle', 70)->nullable();
            $table->text('SEODescription')->nullable();
            $table->string('SEOKeywords', 255)->nullable();
            $table->boolean('IsPublished')->default(true);
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
        Schema::dropIfExists('halaman_solusis');
    }
};
