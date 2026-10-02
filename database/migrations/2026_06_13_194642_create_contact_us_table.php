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
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->date('Tanggal')->nullable();
            $table->string('Email')->nullable();
            $table->string('NamaLengkap')->nullable();
            $table->string('NomorHandphone')->nullable();
            $table->string('CompanyName')->nullable();
            $table->string('LokasiPerusahaan')->nullable();
            $table->string('ProdukYangDibutuhkan')->nullable();
            $table->text('Pesan')->nullable();
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
        Schema::dropIfExists('contact_us');
    }
};
