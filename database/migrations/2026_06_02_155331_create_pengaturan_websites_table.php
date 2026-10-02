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
        Schema::create('pengaturan_websites', function (Blueprint $table) {
            $table->id();

            // === IDENTITAS PERUSAHAAN ===
            $table->string('NamaPerusahaan')->nullable();
            $table->string('NamaSingkat')->nullable();
            $table->string('TaglineWebsite')->nullable();
            $table->text('DeskripsiSingkat')->nullable();
            $table->longText('TentangPerusahaan')->nullable();

            // === BRANDING & VISUAL ===
            $table->string('PathLogo')->nullable();
            $table->string('PathLogoGelap')->nullable();
            $table->string('PathFavicon')->nullable();
            $table->string('PathOgImage')->nullable();
            $table->string('WarnaUtama', 7)->default('#0d6efd');
            $table->string('WarnaSekunder', 7)->nullable();
            $table->string('FontUtama', 50)->default('Inter');

            // === KONTAK & LOKASI ===
            $table->string('NomorTelepon')->nullable();
            $table->string('NomorWhatsApp')->nullable();
            $table->string('AlamatEmail')->nullable();
            $table->text('AlamatKantor')->nullable();
            $table->string('Kota')->nullable();
            $table->string('KodePos')->nullable();
            $table->string('Provinsi')->nullable();
            $table->string('Negara')->default('Indonesia');
            $table->string('TautanGoogleMaps')->nullable();
            $table->string('EmbedGoogleMaps')->nullable();

            // === MEDIA SOSIAL ===
            $table->string('SosialFacebook')->nullable();
            $table->string('SosialInstagram')->nullable();
            $table->string('SosialTwitter')->nullable();
            $table->string('SosialLinkedIn')->nullable();
            $table->string('SosialYoutube')->nullable();
            $table->string('SosialTiktok')->nullable();

            // === LEGAL & PERIZINAN (Khas Indonesia) ===
            $table->string('NomorNIB')->nullable();
            $table->string('NomorNPWP')->nullable();
            $table->string('PathLogoNPWP')->nullable();
            $table->string('NamaDirektur')->nullable();
            $table->string('JabatanDirektur')->nullable();
            $table->text('RekeningBank')->nullable();

            // === SEO & ANALYTICS ===
            $table->text('KataKunciSEO')->nullable();
            $table->string('PenulisMeta')->nullable();
            $table->string('IdGoogleAnalytics')->nullable();
            $table->string('IdGoogleTagManager')->nullable();
            $table->text('ScriptHeaderCustom')->nullable();

            // === OPERASIONAL ===
            $table->string('JamOperasional')->nullable();
            $table->string('ZonaWaktu')->default('Asia/Jakarta');
            $table->string('BahasaDefault')->default('id');

            // === SYSTEM & MAINTENANCE ===
            $table->boolean('ModeMaintenance')->default(false);
            $table->string('PesanMaintenance')->nullable();
            $table->boolean('AktifkanCookieConsent')->default(true);
            $table->text('TeksCookieConsent')->nullable();

            // === COPYRIGHT & FOOTER ===
            $table->string('TeksCopyright')->nullable();
            $table->string('TautanKebijakanPrivasi')->nullable();
            $table->string('TautanSyaratKetentuan')->nullable();
            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_websites');
    }
};
