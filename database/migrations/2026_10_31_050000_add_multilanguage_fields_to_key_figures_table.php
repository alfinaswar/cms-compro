<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom multi-bahasa (English) untuk Key Figures.
     * Kolom tanpa suffix 'En' tetap menjadi bahasa default (Indonesia).
     */
    public function up(): void
    {
        Schema::table('key_figures', function (Blueprint $table) {
            if (!Schema::hasColumn('key_figures', 'KontenEn')) {
                $table->string('KontenEn')->nullable()->after('Konten');
            }
            if (!Schema::hasColumn('key_figures', 'KeteranganEn')) {
                $table->string('KeteranganEn')->nullable()->after('Keterangan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('key_figures', function (Blueprint $table) {
            foreach (['KontenEn', 'KeteranganEn'] as $col) {
                if (Schema::hasColumn('key_figures', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
