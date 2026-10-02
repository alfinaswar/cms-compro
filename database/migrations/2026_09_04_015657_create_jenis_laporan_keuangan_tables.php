<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // === HEADER: JENIS LAPORAN ===
        Schema::create('jenis_laporan_keuangan', function (Blueprint $table) {
            $table->id();

            $table->string('NamaJenis');
            $table->string('Slug')->unique();
            $table->text('Deskripsi')->nullable();
            $table->string('IconKategori', 50)->default('fa-file-alt');
            $table->string('WarnaBadge', 20)->default('primary');
            $table->integer('Urutan')->default(0);
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // === DETAIL: DOKUMEN LAPORAN ===
        Schema::create('laporan_keuangan_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('JenisLaporanId')->constrained('jenis_laporan_keuangan')->onDelete('cascade');

            $table->string('Judul');
            $table->text('Deskripsi')->nullable();
            $table->string('PathFile'); // File PDF/Excel
            $table->string('FileSize')->nullable(); // Dalam MB
            $table->date('TahunPeriode');
            $table->string('Bahasa', 10)->default('ID'); // ID/EN
            $table->integer('JumlahDownload')->default(0);
            $table->integer('Urutan')->default(0);
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangan_details');
        Schema::dropIfExists('jenis_laporan_keuangan');
    }
};
