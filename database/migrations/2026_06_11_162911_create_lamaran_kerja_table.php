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
        Schema::create('lamaran_kerja', function (Blueprint $table) {
            $table->string('LowonganKerjaId');
            $table->string('NamaLengkap');
            $table->string('Email');
            $table->string('NoHp');
            $table->string('PathCv');
            $table->string('EkspetasiGaji')->nullable();
            $table->text('DeskripsiSingkat')->nullable();
            $table->enum('Status', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamaran_kerja');
    }
};
