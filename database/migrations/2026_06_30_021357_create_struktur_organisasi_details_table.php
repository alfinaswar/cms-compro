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
        Schema::create('struktur_organisasi_details', function (Blueprint $table) {
            $table->id();
            $table->string('StrukturOrganisasiId')->constrained('struktur_organisasis')->onDelete('cascade');
            $table->string('NamaLengkap');
            $table->string('PathFoto')->nullable();
            $table->string('Jabatan');
            $table->text('DeskripsiSingkat')->nullable();
            $table->integer('Urutan')->default(0);
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif');
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
        Schema::dropIfExists('struktur_organisasi_details');
    }
};
