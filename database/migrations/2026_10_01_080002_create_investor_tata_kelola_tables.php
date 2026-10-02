<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Bagan Organisasi & Info Sekretariat
        Schema::create('bagan_organisasis', function (Blueprint $table) {
            $table->id();
            $table->string('Judul')->default('Bagan Struktur Organisasi Perseroan');
            $table->date('TanggalDiperbarui')->nullable();
            $table->string('PathGambar')->nullable();
            $table->string('PathFilePdf')->nullable();
            $table->text('Keterangan')->nullable();
            $table->string('EmailSekretariat')->default('corsec@jasuindo.com');
            $table->string('TeleponSekretariat')->default('+62 31 891 0619');
            $table->text('AlamatSekretariat')->nullable();

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // 2. Manajemen Perseroan (Dewan Komisaris & Direksi)
        Schema::create('manajemen_tata_kelolas', function (Blueprint $table) {
            $table->id();
            $table->string('Nama');
            $table->string('Jabatan');
            $table->enum('Kategori', ['Dewan Komisaris', 'Direksi Perseroan'])->default('Dewan Komisaris');
            $table->string('Foto')->nullable();
            $table->text('DeskripsiSingkat')->nullable();
            $table->longText('ProfilLengkap')->nullable(); // Untuk modal popup detail deskripsi
            $table->integer('Urutan')->default(0);
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // 3. Dokumen Tata Kelola & Kebijakan Operasional
        Schema::create('dokumen_tata_kelolas', function (Blueprint $table) {
            $table->id();
            $table->string('Judul');
            $table->enum('Kategori', [
                'Dokumen Tata Kelola',
                'Kebijakan Operasional',
                'Komite Audit',
                'Satuan Audit Internal'
            ])->default('Dokumen Tata Kelola');
            $table->text('Deskripsi')->nullable();
            $table->string('PathFile')->nullable();
            $table->string('FileSize', 50)->nullable();
            $table->string('ExternalUrl')->nullable();
            $table->integer('Urutan')->default(0);
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // 4. Rapat Umum Pemegang Saham (RUPS)
        Schema::create('rups_dokumens', function (Blueprint $table) {
            $table->id();
            $table->integer('Tahun')->default(2024);
            $table->string('Judul');
            $table->string('KategoriDokumen')->nullable(); // Ringkasan Risalah, Pemberitahuan, Panggilan, CV, Surat Kuasa
            $table->enum('StatusKegiatan', ['Terjadwal', 'Selesai'])->default('Selesai');
            $table->string('PathFile')->nullable();
            $table->string('FileSize', 50)->nullable();
            $table->integer('Urutan')->default(0);
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // 5. Laporan Whistleblowing System (WBS)
        Schema::create('wbs_laporans', function (Blueprint $table) {
            $table->id();
            $table->string('NomorTiket', 50)->unique();
            $table->string('NamaPelapor')->nullable(); // Boleh anonim
            $table->string('EmailPelapor')->nullable();
            $table->string('TeleponPelapor')->nullable();
            $table->string('KategoriPelanggaran');
            $table->string('Terlapor')->nullable();
            $table->date('WaktuKejadian')->nullable();
            $table->string('LokasiKejadian')->nullable();
            $table->text('UraianKejadian');
            $table->string('PathBukti')->nullable();
            $table->enum('StatusLaporan', ['Menunggu Review', 'Sedang Diproses', 'Selesai', 'Ditolak'])->default('Menunggu Review');
            $table->text('CatatanTindakLanjut')->nullable();

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wbs_laporans');
        Schema::dropIfExists('rups_dokumens');
        Schema::dropIfExists('dokumen_tata_kelolas');
        Schema::dropIfExists('manajemen_tata_kelolas');
        Schema::dropIfExists('bagan_organisasis');
    }
};
