<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            $table->string('LinkCTAEn', 255)->nullable()->after('LinkCTA');
            $table->string('LinkCTA2En', 255)->nullable()->after('LinkCTA2');
        });
    }

    public function down(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            $table->dropColumn(['LinkCTAEn', 'LinkCTA2En']);
        });
    }
};
