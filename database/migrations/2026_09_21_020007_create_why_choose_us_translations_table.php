<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('why_choose_us_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('why_choose_us_id');
            $table->string('Locale', 10)->default('id');

            // Field yang diterjemahkan
            $table->string('Judul')->nullable();
            $table->text('Deskripsi')->nullable();

            $table->unique(['why_choose_us_id', 'Locale']);
            $table->timestamps();

            $table->foreign('why_choose_us_id')->references('id')->on('why_choose_us')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_choose_us_translations');
    }
};
