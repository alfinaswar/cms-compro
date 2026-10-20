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
        if (Schema::hasTable('halaman_solusi_subpage_item_translations')) {
            return;
        }

        Schema::create('halaman_solusi_subpage_item_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('HalamanSolusiSubpageItemId');
            $table->string('Locale', 10)->default('id');

            $table->string('Judul')->nullable();       // Judul item / Pertanyaan (faq)
            $table->string('SubJudul')->nullable();    // Sub judul item (komponen section1)
            $table->text('Deskripsi')->nullable();     // Deskripsi item / Jawaban (faq)
            $table->json('Items')->nullable();         // Poin-poin keunggulan (section1)

            $table->unique(
                ['HalamanSolusiSubpageItemId', 'Locale'],
                'hssit_item_locale_unique'
            );
            $table->timestamps();

            $table->foreign('HalamanSolusiSubpageItemId', 'hssit_item_fk')
                ->references('id')->on('halaman_solusi_subpage_items')
                ->cascadeOnDelete();
        });

        // Backfill: salin konten item yang sudah ada sebagai terjemahan 'id'
        foreach (DB::table('halaman_solusi_subpage_items')->get() as $row) {
            DB::table('halaman_solusi_subpage_item_translations')->insert([
                'HalamanSolusiSubpageItemId' => $row->id,
                'Locale'                     => 'id',
                'Judul'                      => $row->Judul ?? null,
                'SubJudul'                   => $row->SubJudul ?? null,
                'Deskripsi'                  => $row->Deskripsi ?? null,
                'Items'                      => $row->Items ?? null,
                'created_at'                 => now(),
                'updated_at'                 => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('halaman_solusi_subpage_item_translations')) {
            return;
        }

        Schema::dropIfExists('halaman_solusi_subpage_item_translations');
    }
};
