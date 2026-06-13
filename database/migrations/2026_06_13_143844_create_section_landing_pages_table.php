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
        Schema::create('section_landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('Tipe');
            $table->string('Judul');
            $table->text('Deskripsi')->nullable();
            $table->string('Gambar')->nullable();
            $table->json('Konten')->nullable();
            $table->integer('Urutan')->default(0);
            $table->boolean('StatusAktif')->default(true);
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
        Schema::dropIfExists('section_landing_pages');
    }
};
