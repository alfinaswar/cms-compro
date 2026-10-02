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
        Schema::table('hero_sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('hero_sliders', 'Video')) {
                $table->string('Video')->nullable()->after('GambarLatar');
            }
            if (!Schema::hasColumn('hero_sliders', 'TeksCTA')) {
                $table->string('TeksCTA')->nullable()->after('Video');
            }
            if (!Schema::hasColumn('hero_sliders', 'LinkCTA')) {
                $table->string('LinkCTA')->nullable()->after('TeksCTA');
            }
            if (!Schema::hasColumn('hero_sliders', 'TeksCTA2')) {
                $table->string('TeksCTA2')->nullable()->after('LinkCTA');
            }
            if (!Schema::hasColumn('hero_sliders', 'LinkCTA2')) {
                $table->string('LinkCTA2')->nullable()->after('TeksCTA2');
            }
        });
    }

    public function down(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            $columns = ['Deskripsi', 'TipeMedia', 'Video', 'TeksCTA', 'LinkCTA', 'TeksCTA2', 'LinkCTA2', 'Urutan'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('hero_sliders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
