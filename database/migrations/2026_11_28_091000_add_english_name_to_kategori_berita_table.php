<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori_berita', function (Blueprint $table) {
            $table->string('NamaKategoriEn', 100)->nullable()->after('NamaKategori');
        });
    }

    public function down(): void
    {
        Schema::table('kategori_berita', function (Blueprint $table) {
            $table->dropColumn('NamaKategoriEn');
        });
    }
};
