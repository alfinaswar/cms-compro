<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_banners', function (Blueprint $table) {
            $table->id();
            $table->string('Title', 255)->nullable();
            $table->string('ImagePath', 500);
            $table->string('LinkUrl', 500)->nullable();
            $table->boolean('IsActive')->default(true);
            $table->integer('Urutan')->default(1);
            $table->string('UserCreate', 100)->nullable();
            $table->string('UserUpdate', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_banners');
    }
};
