<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('security_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('NomorTier', 20)->nullable();
            $table->string('Icon')->nullable();
            $table->integer('Urutan')->default(0);
            $table->boolean('Status')->default(1);
            $table->timestamps();
        });

        Schema::create('security_tier_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('security_tier_id');
            $table->string('Locale', 10)->default('id');
            $table->string('Judul')->nullable();
            $table->text('Deskripsi')->nullable();
            $table->json('Features')->nullable();

            $table->unique(['security_tier_id', 'Locale']);
            $table->timestamps();

            $table->foreign('security_tier_id')->references('id')->on('security_tiers')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_tier_translations');
        Schema::dropIfExists('security_tiers');
    }
};
