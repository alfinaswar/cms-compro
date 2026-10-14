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
        Schema::table('master_kantors', function (Blueprint $table) {
            $table->string('HubunganInvestorNama')->nullable()->after('AlamatEmail');
            $table->string('HubunganInvestorJabatan')->nullable()->after('HubunganInvestorNama');
            $table->string('HubunganInvestorEmail')->nullable()->after('HubunganInvestorJabatan');
            $table->string('PasarEksporNama')->nullable()->after('HubunganInvestorEmail');
            $table->string('PasarEksporJabatan')->nullable()->after('PasarEksporNama');
            $table->string('PasarEksporEmail')->nullable()->after('PasarEksporJabatan');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus field bila migration di-rollback
        Schema::table('master_kantors', function (Blueprint $table) {
            $table->dropColumn([
                'hubungan_investor_nama',
                'hubungan_investor_jabatan',
                'hubungan_investor_email',
                'pasar_ekspor_nama',
                'pasar_ekspor_jabatan',
                'pasar_ekspor_email'
            ]);
        });
    }
};
