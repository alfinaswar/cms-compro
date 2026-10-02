<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master Pos/Baris Keuangan
        Schema::create('ringkasan_kinerja_pos', function (Blueprint $table) {
            $table->id();
            $table->string('Kategori'); // 'Laba Rugi', 'Posisi Keuangan', 'Rasio', 'Saham & Dividen'
            $table->string('KodePos')->nullable()->index(); // Unique key for chart automation (e.g. pendapatan_usaha, laba_bersih)
            $table->string('NamaPos');
            $table->string('Catatan')->nullable();
            $table->string('Satuan')->default('Jutaan IDR');
            $table->boolean('IsSubPos')->default(false);
            $table->boolean('IsBold')->default(false);
            $table->boolean('IsHighlight')->default(false);
            $table->integer('Urutan')->default(0);
            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Transaksional Nilai per Pos per Tahun (Unlimited Years, Relasional Normal)
        Schema::create('ringkasan_kinerja_nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('PosId')->constrained('ringkasan_kinerja_pos')->onDelete('cascade');
            $table->integer('Tahun')->index(); // 2021, 2022, 2023, 2024, 2025, 2026...
            $table->string('NilaiTampil')->nullable(); // "1.150.320", "(820.150)", "12,4%", "2,05x"
            $table->decimal('NilaiAngka', 18, 2)->nullable(); // Angka murni untuk kalkulasi & diagram batang
            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['PosId', 'Tahun']);
        });

        // 3. Pengaturan Tampilan Periode & Highlight
        Schema::create('pengaturan_kinerja_keuangans', function (Blueprint $table) {
            $table->id();
            $table->enum('ModeWindow', ['Otomatis', 'Kustom'])->default('Kustom');
            $table->integer('JumlahTahun')->default(5);
            $table->integer('TahunMulai')->default(2021);
            $table->integer('TahunSelesai')->default(2025);
            $table->string('PertumbuhanRevenue')->default('+31.5% YoY (2025)');
            $table->string('PertumbuhanProfit')->default('+47.7% YoY (2025)');
            $table->string('Subjudul')->default('Ringkasan kinerja keuangan utama perusahaan selama 5 tahun terakhir (2021 - 2025).');
            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_kinerja_keuangans');
        Schema::dropIfExists('ringkasan_kinerja_nilais');
        Schema::dropIfExists('ringkasan_kinerja_pos');
    }
};
