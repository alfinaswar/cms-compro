<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom multi-bahasa (English) untuk Hero Slider.
     * Kolom tanpa suffix 'En' tetap menjadi bahasa default (Indonesia).
     */
    public function up(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('hero_sliders', 'SubJudulEn')) {
                $table->string('SubJudulEn')->nullable()->after('SubJudul');
            }
            if (!Schema::hasColumn('hero_sliders', 'JudulUtamaEn')) {
                $table->string('JudulUtamaEn')->nullable()->after('JudulUtama');
            }
            if (!Schema::hasColumn('hero_sliders', 'Highlight')) {
                $table->string('Highlight')->nullable()->after('JudulUtamaEn');
            }
            if (!Schema::hasColumn('hero_sliders', 'HighlightEn')) {
                $table->string('HighlightEn')->nullable()->after('Highlight');
            }
            if (!Schema::hasColumn('hero_sliders', 'TeksPenuh')) {
                $table->string('TeksPenuh')->nullable()->after('HighlightEn');
            }
            if (!Schema::hasColumn('hero_sliders', 'TeksPenuhEn')) {
                $table->string('TeksPenuhEn')->nullable()->after('TeksPenuh');
            }
            if (!Schema::hasColumn('hero_sliders', 'DeskripsiEn')) {
                $table->string('DeskripsiEn')->nullable()->after('Deskripsi');
            }
            if (!Schema::hasColumn('hero_sliders', 'TeksCTAEn')) {
                $table->string('TeksCTAEn')->nullable()->after('TeksCTA');
            }
            if (!Schema::hasColumn('hero_sliders', 'TeksCTA2En')) {
                $table->string('TeksCTA2En')->nullable()->after('TeksCTA2');
            }
        });
    }

    public function down(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            $columns = [
                'SubJudulEn', 'JudulUtamaEn', 'Highlight', 'HighlightEn',
                'TeksPenuh', 'TeksPenuhEn', 'DeskripsiEn', 'TeksCTAEn', 'TeksCTA2En',
            ];
            foreach ($columns as $col) {
                if (Schema::hasColumn('hero_sliders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
