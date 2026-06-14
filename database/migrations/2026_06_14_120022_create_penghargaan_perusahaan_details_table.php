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
        Schema::create('penghargaan_perusahaan_details', function (Blueprint $table) {
            $table->id();
            $table->string('PenghargaanId')->nullable();
            $table->string('Judul')->nullable();
            $table->text('Deskripsi')->nullable();
            $table->string('Gambar')->nullable();
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
        Schema::dropIfExists('penghargaan_perusahaan_details');
    }
};
