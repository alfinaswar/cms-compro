<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menu_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('MenuId');
            $table->string('Locale', 10)->default('id');
            $table->string('NamaMenu');

            $table->unique(['MenuId', 'Locale']);
            $table->timestamps();

            $table->foreign('MenuId')->references('id')->on('Menu')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_translations');
    }
};
