<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Informasi & Statistik Saham JTPE
        Schema::create('informasi_sahams', function (Blueprint $table) {
            $table->id();
            $table->string('KodeSaham', 20)->default('JTPE');
            $table->decimal('HargaTerakhir', 12, 2)->default(595);
            $table->decimal('Perubahan', 12, 2)->default(16);
            $table->decimal('PersentasePerubahan', 5, 2)->default(2.77);
            $table->string('StatusPasar')->default('Pasar Tutup');
            $table->decimal('Pembukaan', 12, 2)->default(580);
            $table->decimal('PenutupanKemarin', 12, 2)->default(585);
            $table->decimal('TertinggiHariIni', 12, 2)->default(605);
            $table->decimal('TerendahHariIni', 12, 2)->default(585);
            $table->decimal('Tertinggi52Mgg', 12, 2)->default(690);
            $table->decimal('Terendah52Mgg', 12, 2)->default(490);
            $table->bigInteger('VolumeSaham')->default(14831013);
            $table->string('NilaiTransaksi')->default('Rp 8,82 Miliar');
            $table->string('KapitalisasiPasar')->default('Rp 4,08 Triliun');
            $table->json('ChartData')->nullable();

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // 2. Struktur Kepemilikan Saham
        Schema::create('struktur_kepemilikans', function (Blueprint $table) {
            $table->id();
            $table->enum('TipePemodal', ['Pemodal Nasional', 'Pemodal Asing']);
            $table->string('KategoriPemegang'); // Perorangan Indonesia, Koperasi, Yayasan, dll
            $table->bigInteger('JumlahSaham')->default(0);
            $table->decimal('Persentase', 5, 2)->default(0);
            $table->string('PeriodeBulan', 30)->default('Maret');
            $table->string('PeriodeTahun', 10)->default('2024');
            $table->integer('Urutan')->default(0);
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // 3. Skema / Diagram Pemegang Saham Utama & Pengendali
        Schema::create('skema_pengendalis', function (Blueprint $table) {
            $table->id();
            $table->string('Judul')->default('Bagan Struktur Kepemilikan Saham & Pemegang Saham Utama Pengendali');
            $table->string('PathGambar')->nullable();
            $table->string('PathFilePdf')->nullable();
            $table->text('Keterangan')->nullable();

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // 4. Entitas Anak & Perusahaan Asosiasi
        Schema::create('entitas_anaks', function (Blueprint $table) {
            $table->id();
            $table->string('NamaEntitas');
            $table->string('Lokasi')->nullable();
            $table->enum('Tipe', ['Entitas Anak', 'Perusahaan Asosiasi'])->default('Entitas Anak');
            $table->decimal('PersentaseKepemilikan', 5, 2)->default(100.00);
            $table->string('TahunBergabung', 20)->nullable();
            $table->text('BidangUsaha')->nullable();
            $table->string('UrlWebsite')->nullable();
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
        Schema::dropIfExists('entitas_anaks');
        Schema::dropIfExists('skema_pengendalis');
        Schema::dropIfExists('struktur_kepemilikans');
        Schema::dropIfExists('informasi_sahams');
    }
};
