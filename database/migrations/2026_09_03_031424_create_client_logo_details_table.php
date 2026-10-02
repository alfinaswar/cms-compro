<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_logo_details', function (Blueprint $table) {
            $table->id();
            $table->string('IdClientLogo', 100)->nullable();
            $table->string('SubJudul', 200)->nullable();
            $table->string('Judul', 200)->nullable();
            $table->string('Deskripsi', 200)->nullable();
            $table->string('PathLogo', 200)->nullable();
            $table->string('UrlWebsite', 100)->nullable();
            $table->integer('Urutan')->default(0);
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif');
            // === AUDIT TRAIL ===
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
        Schema::dropIfExists('client_logo_details');
    }
};
