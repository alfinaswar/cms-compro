<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $splitText = function (?string $raw): array {
            $raw = (string) ($raw ?? '');
            if (str_contains($raw, '|||')) {
                [$label, $desc] = array_pad(explode('|||', $raw, 2), 2, '');
                return [trim($label) ?: null, trim($desc) ?: null];
            }
            $trimmed = trim($raw);
            return [$trimmed !== '' ? $trimmed : null, null];
        };

        // 1. Update about_us_details where IdAbout = 5
        $heroDetails = DB::table('about_us_details')
            ->where('IdAbout', 5)
            ->whereNull('SubJudul')
            ->get();

        foreach ($heroDetails as $detail) {
            [$label, $desc] = $splitText($detail->Deskripsi);
            DB::table('about_us_details')
                ->where('id', $detail->id)
                ->update([
                    'SubJudul' => $label,
                    'Deskripsi' => $desc,
                ]);
        }

        // 2. Update AboutUsDetailTranslations for hero details
        $heroDetailIds = DB::table('about_us_details')
            ->where('IdAbout', 5)
            ->pluck('id');

        if ($heroDetailIds->isNotEmpty()) {
            $translations = DB::table('AboutUsDetailTranslations')
                ->whereIn('IdAboutUsDetail', $heroDetailIds)
                ->whereNull('SubJudul')
                ->get();

            foreach ($translations as $trans) {
                [$label, $desc] = $splitText($trans->Deskripsi);
                DB::table('AboutUsDetailTranslations')
                    ->where('id', $trans->id)
                    ->update([
                        'SubJudul' => $label,
                        'Deskripsi' => $desc,
                    ]);
            }
        }
    }

    public function down(): void
    {
        // Revert: if SubJudul is present and Deskripsi is null, move SubJudul back to Deskripsi
        $heroDetails = DB::table('about_us_details')
            ->where('IdAbout', 5)
            ->whereNotNull('SubJudul')
            ->get();

        foreach ($heroDetails as $detail) {
            $combined = $detail->SubJudul;
            if (!empty($detail->Deskripsi)) {
                $combined .= '|||' . $detail->Deskripsi;
            }
            DB::table('about_us_details')
                ->where('id', $detail->id)
                ->update([
                    'SubJudul' => null,
                    'Deskripsi' => $combined,
                ]);
        }

        $heroDetailIds = DB::table('about_us_details')
            ->where('IdAbout', 5)
            ->pluck('id');

        if ($heroDetailIds->isNotEmpty()) {
            $translations = DB::table('AboutUsDetailTranslations')
                ->whereIn('IdAboutUsDetail', $heroDetailIds)
                ->whereNotNull('SubJudul')
                ->get();

            foreach ($translations as $trans) {
                $combined = $trans->SubJudul;
                if (!empty($trans->Deskripsi)) {
                    $combined .= '|||' . $trans->Deskripsi;
                }
                DB::table('AboutUsDetailTranslations')
                    ->where('id', $trans->id)
                    ->update([
                        'SubJudul' => null,
                        'Deskripsi' => $combined,
                    ]);
            }
        }
    }
};
