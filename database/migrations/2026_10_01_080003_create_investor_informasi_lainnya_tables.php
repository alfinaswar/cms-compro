<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Lembaga Penunjang Pasar Modal
        Schema::create('lembaga_penunjangs', function (Blueprint $table) {
            $table->id();
            $table->string('NamaInstitusi');
            $table->enum('Kategori', [
                'Kantor Akuntan Publik (KAP)',
                'Biro Administrasi Efek (BAE)',
                'Notaris',
                'Konsultan Hukum',
                'Lainnya'
            ])->default('Kantor Akuntan Publik (KAP)');
            $table->string('Afiliasi')->nullable();
            $table->string('Website')->nullable();
            $table->text('KantorPusat')->nullable();
            $table->text('Cabang')->nullable();
            $table->string('Layanan')->nullable();
            $table->integer('Urutan')->default(0);
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // 2. Keterbukaan Informasi & Pengumuman Material
        Schema::create('keterbukaan_informasis', function (Blueprint $table) {
            $table->id();
            $table->string('Judul');
            $table->enum('Kategori', [
                'Fakta Material',
                'Buyback Saham',
                'Aksi Korporasi',
                'Dividen',
                'Buletin Investor',
                'Lainnya'
            ])->default('Fakta Material');
            $table->date('TanggalPublikasi');
            $table->text('Deskripsi')->nullable();
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

        // 3. Permintaan Dokumen Fisik / Prospektus
        Schema::create('permintaan_dokumen_investors', function (Blueprint $table) {
            $table->id();
            $table->string('Nama');
            $table->string('Email');
            $table->string('Institusi')->nullable();
            $table->string('Telepon', 30)->nullable();
            $table->string('JenisDokumen'); // Salinan Fisik Laporan Tahunan / Prospektus
            $table->text('AlamatPengiriman');
            $table->text('Catatan')->nullable();
            $table->enum('StatusPermintaan', ['Pending', 'Diproses', 'Terkirim', 'Ditolak'])->default('Pending');

            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_dokumen_investors');
        Schema::dropIfExists('keterbukaan_informasis');
        Schema::dropIfExists('lembaga_penunjangs');
    }
};
