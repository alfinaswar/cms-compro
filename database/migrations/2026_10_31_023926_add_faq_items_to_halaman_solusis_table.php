<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('halaman_solusis', function (Blueprint $table) {
            $table->json('FaqItems')->nullable()->after('Konten');
        });

        Schema::table('halaman_solusi_translations', function (Blueprint $table) {
            $table->json('FaqItems')->nullable()->after('Konten');
        });
    }

    public function down(): void
    {
        Schema::table('halaman_solusis', function (Blueprint $table) {
            $table->dropColumn('FaqItems');
        });

        Schema::table('halaman_solusi_translations', function (Blueprint $table) {
            $table->dropColumn('FaqItems');
        });
    }
};
