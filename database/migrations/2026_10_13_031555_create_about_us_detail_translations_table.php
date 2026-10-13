<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('AboutUsDetailTranslations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdAboutUsDetail');
            $table->string('Locale', 5);
            $table->text('Judul')->nullable();
            $table->longText('Deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('AboutUsDetailTranslations');
    }
};
