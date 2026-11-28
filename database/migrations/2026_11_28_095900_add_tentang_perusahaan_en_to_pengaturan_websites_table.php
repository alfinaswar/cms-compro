<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_websites', function (Blueprint $table) {
            $table->longText('TentangPerusahaanEn')->nullable()->after('TentangPerusahaan');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_websites', function (Blueprint $table) {
            $table->dropColumn('TentangPerusahaanEn');
        });
    }
};
