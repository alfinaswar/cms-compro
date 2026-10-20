<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Jangan jalankan kalau tabel sudah ada
        if (Schema::hasTable('halaman_solusi_subpage_translations')) {
            return;
        }

        Schema::create('halaman_solusi_subpage_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('HalamanSolusiSubpageId');
            $table->string('Locale', 10)->default('id');

            // === HERO ===
            $table->string('Judul')->nullable();
            $table->string('SubJudul')->nullable();
            $table->text('Deskripsi')->nullable();
            $table->longText('Konten')->nullable();

            // === SECTION 1 (Komponen) ===
            $table->string('Sec1SubJudul')->nullable();
            $table->string('Sec1Judul')->nullable();
            $table->text('Sec1Deskripsi')->nullable();

            // === SECTION 2 (Solusi / keunggulan) ===
            $table->string('Sec2SubJudul')->nullable();
            $table->string('Sec2Judul')->nullable();
            $table->text('Sec2Deskripsi')->nullable();

            // === SECTION 3 (Keamanan) ===
            $table->string('Sec3SubJudul')->nullable();
            $table->string('Sec3Judul')->nullable();
            $table->text('Sec3Deskripsi')->nullable();

            // === FAQ ===
            $table->string('FaqSubJudul')->nullable();
            $table->string('FaqJudul')->nullable();
            $table->text('FaqDeskripsi')->nullable();

            $table->unique(
                ['HalamanSolusiSubpageId', 'Locale'],
                'hssubt_subpage_locale_unique'
            );
            $table->timestamps();

            $table->foreign('HalamanSolusiSubpageId', 'hssubt_subpage_fk')
                ->references('id')->on('halaman_solusi_subpages')
                ->cascadeOnDelete();
        });

        // Backfill: salin konten subhalaman yang sudah ada sebagai terjemahan 'id'
        $fields = [
            'Judul', 'SubJudul', 'Deskripsi', 'Konten',
            'Sec1SubJudul', 'Sec1Judul', 'Sec1Deskripsi',
            'Sec2SubJudul', 'Sec2Judul', 'Sec2Deskripsi',
            'Sec3SubJudul', 'Sec3Judul', 'Sec3Deskripsi',
            'FaqSubJudul', 'FaqJudul', 'FaqDeskripsi',
        ];

        foreach (DB::table('halaman_solusi_subpages')->get() as $row) {
            $data = [
                'HalamanSolusiSubpageId' => $row->id,
                'Locale'                 => 'id',
                'created_at'             => now(),
                'updated_at'             => now(),
            ];
            foreach ($fields as $field) {
                $data[$field] = $row->{$field} ?? null;
            }
            DB::table('halaman_solusi_subpage_translations')->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('halaman_solusi_subpage_translations')) {
            return;
        }

        Schema::dropIfExists('halaman_solusi_subpage_translations');
    }
};
