<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('static_page', function (Blueprint $table) {
            $table->id();
            $table->string('PageType')->unique(); // privacy_policy, terms_conditions, about_us, dll
            $table->string('Label')->nullable(); // Label tampilan admin
            $table->string('Icon')->nullable(); // fa-icon class
            $table->string('Slug')->nullable();
            $table->string('Thumbnail')->nullable();
            $table->boolean('IsPublished')->default(false);
            $table->integer('Urutan')->default(0);
            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('StaticPages');
    }
};
