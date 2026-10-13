<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('AboutUsTranslations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdAbout');
            $table->string('Locale', 5); // id, en
            $table->text('SubJudul')->nullable();
            $table->text('Judul')->nullable();
            $table->longText('Deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('AboutUsTranslations');
    }
};
