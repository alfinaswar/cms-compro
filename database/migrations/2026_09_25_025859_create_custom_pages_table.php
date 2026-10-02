<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('custom_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ParentId')->nullable();
            $table->string('Slug')->unique()->nullable();
            $table->string('Thumbnail')->nullable();
            $table->integer('Urutan')->default(0);
            $table->boolean('IsPublished')->default(true);
            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('CustomPages');
    }
};
