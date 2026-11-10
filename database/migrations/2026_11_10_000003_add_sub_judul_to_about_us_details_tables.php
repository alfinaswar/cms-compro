<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('about_us_details', 'SubJudul')) {
            Schema::table('about_us_details', function (Blueprint $table) {
                $table->string('SubJudul')->nullable()->after('Gambar');
            });
        }

        if (!Schema::hasColumn('AboutUsDetailTranslations', 'SubJudul')) {
            Schema::table('AboutUsDetailTranslations', function (Blueprint $table) {
                $table->text('SubJudul')->nullable()->after('Locale');
            });
        }

        $fallbackDescriptions = [
            '1990' => [
                'id' => 'Inisiasi operasional percetakan sekuritas tersertifikasi di Sidoarjo, Jawa Timur, yang didedikasikan untuk surat berharga negara, dokumen keamanan tinggi, dan produk sekuritas komersial.',
                'en' => 'Initiated certified security printing operations in Sidoarjo, East Java, dedicated to state securities, high-security documents, and commercial security products.',
            ],
            '2010' => [
                'id' => 'Pengoperasian pabrik kartu pintar terpersonalisasi dan perolehan sertifikasi berlisensi dari Mastercard dan VISA sebagai produsen chip dan biro personalisasi.',
                'en' => 'Operated a personalized smart card factory and obtained licensed certification from Mastercard and VISA as a chip producer and personalization bureau.',
            ],
            '2013' => [
                'id' => 'Pembentukan entitas usaha percetakan sekuritas sovereign bersama Arjowiggins Security, memproduksi paspor elektronik berspesifikasi tinggi dan segel sekuritas merek global.',
                'en' => 'Established a sovereign security printing joint venture with Arjowiggins Security, producing high-specification electronic passports and global brand security seals.',
            ],
            '2018' => [
                'id' => 'Meraih sertifikasi tertinggi INTERGRAF ISO 14298:2013 untuk kategori High Security Printing Management, bersamaan dengan otorisasi resmi jaringan pembayaran global JCB.',
                'en' => 'Achieved the highest INTERGRAF ISO 14298:2013 certification for High Security Printing Management, along with official JCB global payment network authorization.',
            ],
            '2019' => [
                'id' => 'Toppan Printing Co., Ltd. resmi menjadi pemegang saham terbesar kedua, menyuntikkan 300+ portofolio paten global ke dalam peta jalan R&D. Diakui berulang kali oleh Forbes Asia sebagai "Best Under a Billion".',
                'en' => 'Toppan Printing Co., Ltd. officially became the second-largest shareholder, injecting 300+ global patents into the R&D roadmap. Repeatedly recognized by Forbes Asia as "Best Under a Billion".',
            ],
        ];

        $splitTitleDesc = function (?string $raw, string $year, string $locale) use ($fallbackDescriptions): array {
            $raw = (string) ($raw ?? '');
            if (str_contains($raw, '|||')) {
                [$title, $desc] = array_pad(explode('|||', $raw, 2), 2, '');
                $title = trim($title);
                $desc = trim($desc);
            } else {
                $lines = preg_split("/\r\n|\n|\r/", trim(strip_tags($raw)));
                $title = trim($lines[0] ?? '');
                $desc = trim(implode("\n", array_slice($lines, 1)));
            }

            if ($desc === '') {
                $cleanYear = preg_replace('/[^0-9]/', '', $year);
                $desc = $fallbackDescriptions[$cleanYear][$locale] ?? '';
            }

            return [
                $title !== '' ? $title : null,
                $desc !== '' ? $desc : null,
            ];
        };

        $details = DB::table('about_us_details')
            ->where('IdAbout', 1)
            ->whereNull('SubJudul')
            ->get();

        foreach ($details as $detail) {
            $year = trim((string) ($detail->Judul ?? ''));
            [$title, $desc] = $splitTitleDesc($detail->Deskripsi, $year, 'id');

            DB::table('about_us_details')
                ->where('id', $detail->id)
                ->update([
                    'SubJudul' => $year !== '' ? $year : null,
                    'Judul' => $title,
                    'Deskripsi' => $desc,
                ]);
        }

        $detailIds = DB::table('about_us_details')
            ->where('IdAbout', 1)
            ->pluck('id');

        if ($detailIds->isNotEmpty()) {
            $translations = DB::table('AboutUsDetailTranslations')
                ->whereIn('IdAboutUsDetail', $detailIds)
                ->whereNull('SubJudul')
                ->get();

            foreach ($translations as $trans) {
                $year = trim((string) ($trans->Judul ?? ''));
                $locale = $trans->Locale === 'en' ? 'en' : 'id';
                [$title, $desc] = $splitTitleDesc($trans->Deskripsi, $year, $locale);

                DB::table('AboutUsDetailTranslations')
                    ->where('id', $trans->id)
                    ->update([
                        'SubJudul' => $year !== '' ? $year : null,
                        'Judul' => $title,
                        'Deskripsi' => $desc,
                    ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('about_us_details', 'SubJudul')) {
            $details = DB::table('about_us_details')
                ->where('IdAbout', 1)
                ->whereNotNull('SubJudul')
                ->get();

            foreach ($details as $detail) {
                $combined = trim((string) ($detail->Judul ?? ''));
                if (!empty($detail->Deskripsi)) {
                    $combined .= '|||' . $detail->Deskripsi;
                }

                DB::table('about_us_details')
                    ->where('id', $detail->id)
                    ->update([
                        'Judul' => $detail->SubJudul,
                        'Deskripsi' => $combined !== '' ? $combined : null,
                    ]);
            }

            Schema::table('about_us_details', function (Blueprint $table) {
                $table->dropColumn('SubJudul');
            });
        }

        if (Schema::hasColumn('AboutUsDetailTranslations', 'SubJudul')) {
            $detailIds = DB::table('about_us_details')
                ->where('IdAbout', 1)
                ->pluck('id');

            if ($detailIds->isNotEmpty()) {
                $translations = DB::table('AboutUsDetailTranslations')
                    ->whereIn('IdAboutUsDetail', $detailIds)
                    ->whereNotNull('SubJudul')
                    ->get();

                foreach ($translations as $trans) {
                    $combined = trim((string) ($trans->Judul ?? ''));
                    if (!empty($trans->Deskripsi)) {
                        $combined .= '|||' . $trans->Deskripsi;
                    }

                    DB::table('AboutUsDetailTranslations')
                        ->where('id', $trans->id)
                        ->update([
                            'Judul' => $trans->SubJudul,
                            'Deskripsi' => $combined !== '' ? $combined : null,
                        ]);
                }
            }

            Schema::table('AboutUsDetailTranslations', function (Blueprint $table) {
                $table->dropColumn('SubJudul');
            });
        }
    }
};
