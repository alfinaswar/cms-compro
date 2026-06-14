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
        Schema::create('halaman_solusi_details', function (Blueprint $table) {
            $table->id();
            $table->string('HalamanSolusiId')->nullable();
            $table->string('Judul')->nullable();
            $table->string('Gambar')->nullable();
            $table->text('Keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halaman_solusi_details');
    }
};
