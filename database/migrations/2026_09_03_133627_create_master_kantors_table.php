<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_kantors', function (Blueprint $table) {
            $table->id();
            $table->string('NamaKantor')->nullable();
            $table->enum('TipeKantor', ['Pusat', 'Cabang'])->default('Pusat')->nullable();
            $table->integer('Urutan')->default(0)->nullable();
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif')->nullable();
            $table->text('AlamatLengkap')->nullable();
            $table->string('Kota')->nullable();
            $table->string('Provinsi')->nullable();
            $table->string('KodePos')->nullable();
            $table->string('TautanGoogleMaps')->nullable();
            $table->text('EmbedGoogleMaps')->nullable();
            $table->string('NomorTelepon')->nullable();
            $table->string('NomorWhatsApp')->nullable();
            $table->string('AlamatEmail')->nullable();
            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_kantors');
    }
};
