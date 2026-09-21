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
        Schema::create('halaman_solusi_detail_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('halaman_solusi_detail_id');
            $table->string('Locale', 10)->default('id');

            $table->string('Judul')->nullable();
            $table->text('Keterangan')->nullable();
            $table->unique(
                ['halaman_solusi_detail_id', 'Locale'],
                'hsdt_hsdid_locale_unique'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('halaman_solusi_detail_translations', function (Blueprint $table) {
            // Drop the foreign key constraint with the custom name first (avoid errors)
            $table->dropForeign('hsdt_hsdid_fk');
        });

        Schema::dropIfExists('halaman_solusi_detail_translations');
    }
};
