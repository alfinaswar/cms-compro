<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SecurityTier;
use App\Models\SecurityTierTranslation;

class SecurityTierSeeder extends Seeder
{
    public function run(): void
    {
        $tiers = [
            [
                'NomorTier' => '01',
                'Icon' => 'fa-regular fa-eye',
                'Urutan' => 1,
                'Status' => 1,
                'id' => [
                    'Judul' => 'Fitur Keamanan Kasat Mata',
                    'Deskripsi' => 'Elemen keamanan visual yang dapat diverifikasi tanpa alat khusus.',
                    'Features' => [
                        ['t' => 'Diffractive OVD Hologram', 'd' => 'Citra kinetik 2D/3D & microtext.'],
                        ['t' => 'Visual Effect Ink / OVI', 'd' => 'Perubahan warna dua nada saat dimiringkan.'],
                    ],
                ],
                'en' => [
                    'Judul' => 'Overt Security Features',
                    'Deskripsi' => 'Visual security elements verifiable without special tools.',
                    'Features' => [
                        ['t' => 'Diffractive OVD Hologram', 'd' => '2D/3D kinetic images & microtext.'],
                        ['t' => 'Visual Effect Ink / OVI', 'd' => 'Two-tone color shift when tilted.'],
                    ],
                ],
            ],
            [
                'NomorTier' => '02',
                'Icon' => 'fa-solid fa-sliders',
                'Urutan' => 2,
                'Status' => 1,
                'id' => [
                    'Judul' => 'Fitur Keamanan Tersembunyi',
                    'Deskripsi' => 'Fitur tersembunyi yang membutuhkan alat deteksi sederhana.',
                    'Features' => [
                        ['t' => 'Fluorescent Ink / UV', 'd' => 'Menyala di bawah panjang gelombang UV & IR.'],
                        ['t' => 'High-Security Microtext', 'd' => 'Baris teks berulang yang sangat kecil.'],
                    ],
                ],
                'en' => [
                    'Judul' => 'Covert Security Features',
                    'Deskripsi' => 'Hidden features requiring simple detection tools.',
                    'Features' => [
                        ['t' => 'Fluorescent Ink / UV', 'd' => 'Glows under UV & IR wavelengths.'],
                        ['t' => 'High-Security Microtext', 'd' => 'Extremely small repeating text lines.'],
                    ],
                ],
            ],
            [
                'NomorTier' => '03',
                'Icon' => 'fa-solid fa-qrcode',
                'Urutan' => 3,
                'Status' => 1,
                'id' => [
                    'Judul' => 'Sistem Pelacakan & Rekam Jejak',
                    'Deskripsi' => 'Penomoran machine-readable untuk autentikasi & integrasi.',
                    'Features' => [
                        ['t' => 'Serialization & QR Cryptoglyph', 'd' => 'Kode unik per dokumen, anti-pemalsuan.'],
                        ['t' => 'RFID & NFC Auto Sync', 'd' => 'Verifikasi data chip real-time.'],
                    ],
                ],
                'en' => [
                    'Judul' => 'Tracking & Traceability System',
                    'Deskripsi' => 'Machine-readable numbering for authentication & integration.',
                    'Features' => [
                        ['t' => 'Serialization & QR Cryptoglyph', 'd' => 'Unique code per document, tamper-proof.'],
                        ['t' => 'RFID & NFC Auto Sync', 'd' => 'Real-time chip data verification.'],
                    ],
                ],
            ],
            [
                'NomorTier' => '04',
                'Icon' => 'fa-solid fa-fingerprint',
                'Urutan' => 4,
                'Status' => 1,
                'id' => [
                    'Judul' => 'Fitur Keamanan Khusus & Forensik',
                    'Deskripsi' => 'Fitur tingkat laboratorium untuk penegakan hukum.',
                    'Features' => [
                        ['t' => 'Simulant Chemical Taggant', 'd' => 'Mikro-kimia unik per institusi.'],
                        ['t' => 'Kripto / SAM Enclaves', 'd' => 'Kunci kriptografi pada perangkat keras aman.'],
                    ],
                ],
                'en' => [
                    'Judul' => 'Special & Forensic Security',
                    'Deskripsi' => 'Laboratory-level features for legal enforcement.',
                    'Features' => [
                        ['t' => 'Simulant Chemical Taggant', 'd' => 'Micro-chemistry unique to each institution.'],
                        ['t' => 'Kripto / SAM Enclaves', 'd' => 'Cryptographic keys in secure hardware.'],
                    ],
                ],
            ],
        ];

        foreach ($tiers as $tierData) {
            $tier = SecurityTier::create([
                'NomorTier' => $tierData['NomorTier'],
                'Icon' => $tierData['Icon'],
                'Urutan' => $tierData['Urutan'],
                'Status' => $tierData['Status'],
            ]);

            foreach (['id', 'en'] as $locale) {
                SecurityTierTranslation::create([
                    'security_tier_id' => $tier->id,
                    'Locale' => $locale,
                    'Judul' => $tierData[$locale]['Judul'],
                    'Deskripsi' => $tierData[$locale]['Deskripsi'],
                    'Features' => $tierData[$locale]['Features'],
                ]);
            }
        }
    }
}
