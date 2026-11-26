<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_websites', function (Blueprint $table) {
            $table->string('TaglineWebsiteEn', 255)->nullable()->after('TaglineWebsite');
            $table->string('DeskripsiSingkatEn', 500)->nullable()->after('DeskripsiSingkat');
            $table->text('KataKunciSEOEn')->nullable()->after('KataKunciSEO');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_websites', function (Blueprint $table) {
            $table->dropColumn(['TaglineWebsiteEn', 'DeskripsiSingkatEn', 'KataKunciSEOEn']);
        });
    }
};
