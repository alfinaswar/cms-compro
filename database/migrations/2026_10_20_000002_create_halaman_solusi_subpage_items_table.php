<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Jangan jalankan kalau tabel sudah ada
        if (Schema::hasTable('halaman_solusi_subpage_items')) {
            return;
        }

        Schema::create('halaman_solusi_subpage_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('HalamanSolusiSubpageId');

            // Penanda bagian section: section1 | section2 | section3 | faq
            $table->string('Section', 20)->default('section1');

            $table->string('Judul')->nullable();       // Judul item / Pertanyaan (faq)
            $table->string('SubJudul')->nullable();    // Sub judul item (komponen section1)
            $table->text('Deskripsi')->nullable();     // Deskripsi item / Jawaban (faq)
            $table->string('Tipe')->nullable();        // Tipe layout komponen (besar/horizontal)
            $table->string('Icon')->nullable();        // Upload gambar icon (section2/3)
            $table->string('Gambar')->nullable();      // Upload gambar komponen (section1)
            $table->json('Items')->nullable();         // Poin-poin keunggulan (section1)
            $table->integer('SortOrder')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('HalamanSolusiSubpageId')
                ->references('id')->on('halaman_solusi_subpages')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('halaman_solusi_subpage_items')) {
            return;
        }
        Schema::dropIfExists('halaman_solusi_subpage_items');
    }
};
