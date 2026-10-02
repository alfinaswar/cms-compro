<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InformasiSaham;
use App\Models\StrukturKepemilikan;
use App\Models\SkemaPengendali;
use App\Models\EntitasAnak;
use App\Models\BaganOrganisasi;
use App\Models\ManajemenTataKelola;
use App\Models\DokumenTataKelola;
use App\Models\RupsDokumen;
use App\Models\LembagaPenunjang;
use App\Models\KeterbukaanInformasi;

class InvestorPagesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Informasi Saham
        InformasiSaham::firstOrCreate(
            ['KodeSaham' => 'JTPE'],
            [
                'HargaTerakhir' => 595,
                'Perubahan' => 16,
                'PersentasePerubahan' => 2.77,
                'StatusPasar' => 'Pasar Tutup - 28 Mar 2024',
                'Pembukaan' => 580,
                'PenutupanKemarin' => 585,
                'TertinggiHariIni' => 605,
                'TerendahHariIni' => 585,
                'Tertinggi52Mgg' => 690,
                'Terendah52Mgg' => 490,
                'VolumeSaham' => 14831013,
                'NilaiTransaksi' => 'Rp 8,82 Miliar',
                'KapitalisasiPasar' => 'Rp 4,08 Triliun',
                'ChartData' => [
                    ['date' => '22 Mar', 'price' => 575],
                    ['date' => '25 Mar', 'price' => 580],
                    ['date' => '26 Mar', 'price' => 585],
                    ['date' => '27 Mar', 'price' => 585],
                    ['date' => '28 Mar', 'price' => 595],
                ],
                'UserCreate' => 'System',
            ]
        );

        // 2. Struktur Kepemilikan
        $kepemilikanData = [
            ['TipePemodal' => 'Pemodal Nasional', 'KategoriPemegang' => 'Perorangan Indonesia', 'JumlahSaham' => 1233178600, 'Persentase' => 72.54, 'Urutan' => 1],
            ['TipePemodal' => 'Pemodal Nasional', 'KategoriPemegang' => 'Koperasi', 'JumlahSaham' => 0, 'Persentase' => 0.00, 'Urutan' => 2],
            ['TipePemodal' => 'Pemodal Nasional', 'KategoriPemegang' => 'Yayasan', 'JumlahSaham' => 0, 'Persentase' => 0.00, 'Urutan' => 3],
            ['TipePemodal' => 'Pemodal Nasional', 'KategoriPemegang' => 'Perseroan Terbatas / Badan Hukum', 'JumlahSaham' => 0, 'Persentase' => 0.00, 'Urutan' => 4],
            ['TipePemodal' => 'Pemodal Nasional', 'KategoriPemegang' => 'Lain-lain', 'JumlahSaham' => 0, 'Persentase' => 0.00, 'Urutan' => 5],
            ['TipePemodal' => 'Pemodal Asing', 'KategoriPemegang' => 'Perorangan Asing', 'JumlahSaham' => 6726200, 'Persentase' => 0.40, 'Urutan' => 6],
            ['TipePemodal' => 'Pemodal Asing', 'KategoriPemegang' => 'Badan Usaha Asing', 'JumlahSaham' => 460095200, 'Persentase' => 27.06, 'Urutan' => 7],
            ['TipePemodal' => 'Pemodal Asing', 'KategoriPemegang' => 'Lain-lain', 'JumlahSaham' => 0, 'Persentase' => 0.00, 'Urutan' => 8],
        ];

        foreach ($kepemilikanData as $item) {
            StrukturKepemilikan::firstOrCreate(
                [
                    'TipePemodal' => $item['TipePemodal'],
                    'KategoriPemegang' => $item['KategoriPemegang'],
                    'PeriodeBulan' => 'Maret',
                    'PeriodeTahun' => '2024'
                ],
                array_merge($item, [
                    'PeriodeBulan' => 'Maret',
                    'PeriodeTahun' => '2024',
                    'Status' => 'Aktif',
                    'UserCreate' => 'System'
                ])
            );
        }

        // 3. Skema Pengendali
        SkemaPengendali::firstOrCreate(
            ['Judul' => 'Bagan Struktur Kepemilikan Saham & Pemegang Saham Utama Pengendali'],
            [
                'Keterangan' => 'Struktur kepemilikan saham pengendali dan penerima manfaat akhir (Ultimate Beneficial Owner) PT Jasuindo Tiga Perkasa Tbk.',
                'UserCreate' => 'System'
            ]
        );

        // 4. Entitas Anak & Perusahaan Asosiasi
        $entitasData = [
            [
                'NamaEntitas' => 'PT Jasuindo Informatika Pratama',
                'Lokasi' => 'Sidoarjo, Jawa Timur',
                'Tipe' => 'Entitas Anak',
                'PersentaseKepemilikan' => 99.98,
                'TahunBergabung' => 'Est. 2012',
                'BidangUsaha' => 'Penyedia solusi kartu pintar, personalisasi e-KTP, sertifikasi digital dan sistem paspor elektronik terintegrasi.',
                'UrlWebsite' => 'https://jasuindo.com',
                'Urutan' => 1
            ],
            [
                'NamaEntitas' => 'PT Jasuindo Solusi Security',
                'Lokasi' => 'Sidoarjo, Jawa Timur',
                'Tipe' => 'Entitas Anak',
                'PersentaseKepemilikan' => 99.00,
                'TahunBergabung' => 'Est. 2021',
                'BidangUsaha' => 'Percetakan khusus dokumen sekuriti tinggi yang membutuhkan proteksi ketat (surat berharga, bank notes, sertifikat).',
                'UrlWebsite' => 'https://jasuindo.com',
                'Urutan' => 2
            ],
            [
                'NamaEntitas' => 'PT Solusi Anak Mandiri',
                'Lokasi' => 'Surabaya, Jawa Timur',
                'Tipe' => 'Entitas Anak',
                'PersentaseKepemilikan' => 99.00,
                'TahunBergabung' => 'Est. 2018',
                'BidangUsaha' => 'Layanan informasi dan administrasi, aplikasi teknologi digital, dan solusi business process terintegrasi.',
                'UrlWebsite' => null,
                'Urutan' => 3
            ],
            [
                'NamaEntitas' => 'PT Solusi Identitas Berkartu',
                'Lokasi' => 'Sidoarjo, Jawa Timur',
                'Tipe' => 'Entitas Anak',
                'PersentaseKepemilikan' => 99.00,
                'TahunBergabung' => 'Est. 2022',
                'BidangUsaha' => 'Layanan teknologi RFID/NFC, smart card solutions dan infrastruktur sistem verifikasi identitas nasional.',
                'UrlWebsite' => null,
                'Urutan' => 4
            ],
            [
                'NamaEntitas' => 'PT Nusa Adidaya Mandiri',
                'Lokasi' => 'Jakarta Selatan',
                'Tipe' => 'Entitas Anak',
                'PersentaseKepemilikan' => 98.00,
                'TahunBergabung' => 'Est. 2018',
                'BidangUsaha' => 'Pengadaan instrumen sekuriti dokumen, transport ticket, supply security paper ke klien perbankan di seluruh Indonesia.',
                'UrlWebsite' => null,
                'Urutan' => 5
            ],
            [
                'NamaEntitas' => 'PT Fauziando Tiga Perkasa',
                'Lokasi' => 'Sidoarjo, Jawa Timur',
                'Tipe' => 'Perusahaan Asosiasi',
                'PersentaseKepemilikan' => 45.00,
                'TahunBergabung' => 'Est. 2017',
                'BidangUsaha' => 'Perusahaan ventura bersama untuk perluasan distribusi produk cetak sekuriti pada segmen instansi pemerintah.',
                'UrlWebsite' => null,
                'Urutan' => 6
            ],
            [
                'NamaEntitas' => 'PT Nuansa Global Solusindo',
                'Lokasi' => 'Surabaya, Jawa Timur',
                'Tipe' => 'Entitas Anak',
                'PersentaseKepemilikan' => 82.00,
                'TahunBergabung' => 'Est. 2015',
                'BidangUsaha' => 'Solusi digital packaging sekuriti, sistem pelabelan, rekayasa barcode dan verifikasi barcode untuk keamanan industri.',
                'UrlWebsite' => null,
                'Urutan' => 7
            ],
        ];

        foreach ($entitasData as $item) {
            EntitasAnak::firstOrCreate(
                ['NamaEntitas' => $item['NamaEntitas']],
                array_merge($item, ['Status' => 'Aktif', 'UserCreate' => 'System'])
            );
        }

        // 5. Bagan Organisasi & Sekretariat
        BaganOrganisasi::firstOrCreate(
            ['Judul' => 'Bagan Struktur Organisasi Perseroan'],
            [
                'TanggalDiperbarui' => '2024-06-02',
                'EmailSekretariat' => 'corsec@jasuindo.com',
                'TeleponSekretariat' => '+62 31 891 0619',
                'AlamatSekretariat' => "Jl. Raya Betro No. 21, Sedati, Sidoarjo 61253",
                'Keterangan' => 'Memastikan efektivitas pembagian tugas yang terarah, akuntabilitas yang jelas, serta pemisahan independen antara fungsi pengawasan (Dewan Komisaris & Komite Audit) dan fungsi eksekutif (Direksi).',
                'UserCreate' => 'System'
            ]
        );

        // 6. Manajemen Perseroan (Dewan Komisaris & Direksi)
        $manajemenData = [
            [
                'Nama' => 'Yongky Wijaya',
                'Jabatan' => 'Komisaris Utama',
                'Kategori' => 'Dewan Komisaris',
                'DeskripsiSingkat' => 'WNI, lahir di Solo 1964. Lulusan Pemasaran (1987). Berpengalaman lebih dari 30 tahun dalam industri dokumen sekuriti dan percetakan terpadu nasional.',
                'ProfilLengkap' => "Warga Negara Indonesia, lahir di Solo pada tahun 1964. Menyelesaikan pendidikan Sarjana Pemasaran pada tahun 1987. Bergabung dengan Perseroan sejak awal pendirian dan memiliki pengalaman lebih dari 30 tahun dalam memimpin strategi ekspansi bisnis industri dokumen sekuriti, kartu pintar, dan solusi identitas terpadu di Indonesia.",
                'Urutan' => 1
            ],
            [
                'Nama' => 'Prof. Dr. Made Sudarma',
                'Jabatan' => 'Komisaris Independen',
                'Kategori' => 'Dewan Komisaris',
                'DeskripsiSingkat' => 'Guru Besar FEB Universitas Brawijaya Malang, Guru Besar Ilmu Akuntansi. Pakar tata kelola perusahaan (GCG) dan akuntansi forensik.',
                'ProfilLengkap' => "Warga Negara Indonesia. Menjabat sebagai Komisaris Independen merangkap Ketua Komite Audit. Menyandang gelar Guru Besar Bidang Akuntansi dari Fakultas Ekonomi dan Bisnis Universitas Brawijaya Malang. Aktif dalam riset akuntansi forensik, pengawasan internal, dan penegakan prinsip Good Corporate Governance.",
                'Urutan' => 2
            ],
            [
                'Nama' => 'Jean-Pierre Ting',
                'Jabatan' => 'Komisaris',
                'Kategori' => 'Dewan Komisaris',
                'DeskripsiSingkat' => 'WNA Swiss, lahir 14 November 1957. MBA dari University of Geneva. Ahli strategi investasi korporasi global dan diversifikasi produk identitas.',
                'ProfilLengkap' => "Warga Negara Swiss, lahir pada 14 November 1957. Memperoleh gelar Master of Business Administration (MBA) dari University of Geneva. Memiliki rekam jejak puluhan tahun di pasar modal internasional, manajemen risiko portofolio, dan kemitraan teknologi sekuriti lintas negara.",
                'Urutan' => 3
            ],
            [
                'Nama' => 'Oei, Allan Wibisono',
                'Jabatan' => 'Direktur Utama',
                'Kategori' => 'Direksi Perseroan',
                'DeskripsiSingkat' => 'Memimpin arah strategis, operational excellence, transformasi digital, serta penguatan pangsa pasar ekspor perseroan.',
                'ProfilLengkap' => "Warga Negara Indonesia. Bertanggung jawab penuh memimpin seluruh jajaran Direksi dalam mengeksekusi rencana strategis jangka pendek dan jangka panjang, akselerasi transformasi digital industri smart card, dan perluasan jangkauan ekspor ke pasar global.",
                'Urutan' => 4
            ],
            [
                'Nama' => 'Drs. Lukito Budiman',
                'Jabatan' => 'Direktur Keuangan & SDM',
                'Kategori' => 'Direksi Perseroan',
                'DeskripsiSingkat' => 'Mengawasi perumusan kebijakan keuangan, pengelolaan likuiditas, manajemen permodalan, serta pengembangan human capital.',
                'ProfilLengkap' => "Warga Negara Indonesia. Berpengalaman luas dalam bidang manajemen keuangan korporasi, perencanaan perpajakan, audit internal, serta transformasi kapabilitas sumber daya manusia yang adaptif terhadap era digital.",
                'Urutan' => 5
            ],
            [
                'Nama' => 'Sulistiono Soetomo',
                'Jabatan' => 'Direktur Operasional',
                'Kategori' => 'Direksi Perseroan',
                'DeskripsiSingkat' => 'Bertanggung jawab atas efisiensi manufaktur, rantai pasok (supply chain), dan integrasi lini percetakan dokumen sekuriti.',
                'ProfilLengkap' => "Warga Negara Indonesia. Berfokus pada implementasi manufaktur berstandar internasional, otomasi pabrik, kepatuhan sertifikasi ISO sekuriti dokumen, dan keandalan sistem pengiriman produk kepada seluruh mitra.",
                'Urutan' => 6
            ],
            [
                'Nama' => 'Oei, Hendro Susanto',
                'Jabatan' => 'Direktur Komersial',
                'Kategori' => 'Direksi Perseroan',
                'DeskripsiSingkat' => 'Mengarahkan strategi penetrasi pasar, customer relationship, kemitraan B2B dan B2G di sektor perbankan dan pemerintahan.',
                'ProfilLengkap' => "Warga Negara Indonesia. Memimpin pengembangan divisi penjualan, relasi strategis dengan institusi perbankan nasional, kementerian, lembaga pemerintah, dan korporasi multinasional.",
                'Urutan' => 7
            ],
            [
                'Nama' => 'Danik Parwita',
                'Jabatan' => 'Direktur Kepatuhan & GCG',
                'Kategori' => 'Direksi Perseroan',
                'DeskripsiSingkat' => 'Memastikan kepatuhan terhadap regulasi OJK, BEI, hukum korporasi, serta penerapan whistleblowing system dan etika kerja.',
                'ProfilLengkap' => "Warga Negara Indonesia. Memastikan kepatuhan total seluruh operasional Perseroan terhadap regulasi pasar modal, tata kelola keterbukaan informasi, dan sistem pencegahan fraud internal.",
                'Urutan' => 8
            ],
        ];

        foreach ($manajemenData as $item) {
            ManajemenTataKelola::firstOrCreate(
                ['Nama' => $item['Nama']],
                array_merge($item, ['Status' => 'Aktif', 'UserCreate' => 'System'])
            );
        }

        // 7. Dokumen Tata Kelola & Kebijakan
        $dokumenData = [
            ['Judul' => 'Pedoman Dewan Komisaris', 'Kategori' => 'Dokumen Tata Kelola', 'Deskripsi' => 'Board of Commissioners Charter', 'FileSize' => '1.2 MB', 'Urutan' => 1],
            ['Judul' => 'Pedoman Direksi', 'Kategori' => 'Dokumen Tata Kelola', 'Deskripsi' => 'Board of Directors Charter', 'FileSize' => '1.1 MB', 'Urutan' => 2],
            ['Judul' => 'Sekretaris Perusahaan', 'Kategori' => 'Dokumen Tata Kelola', 'Deskripsi' => 'Corporate Secretary Appointment & Charter', 'FileSize' => '850 KB', 'Urutan' => 3],
            ['Judul' => 'Kode Etik Perusahaan', 'Kategori' => 'Dokumen Tata Kelola', 'Deskripsi' => 'Code of Corporate Conduct', 'FileSize' => '1.5 MB', 'Urutan' => 4],
            ['Judul' => 'Nominasi & Remunerasi', 'Kategori' => 'Dokumen Tata Kelola', 'Deskripsi' => 'Nomination and Remuneration Policy', 'FileSize' => '950 KB', 'Urutan' => 5],
            ['Judul' => 'Piagam Komite Audit', 'Kategori' => 'Dokumen Tata Kelola', 'Deskripsi' => 'Audit Committee Charter', 'FileSize' => '1.3 MB', 'Urutan' => 6],
            ['Judul' => 'Piagam Satuan Audit Internal', 'Kategori' => 'Satuan Audit Internal', 'Deskripsi' => 'Internal Audit Charter', 'FileSize' => '900 KB', 'Urutan' => 7],
            ['Judul' => 'Kebijakan Manajemen Risiko Keuangan', 'Kategori' => 'Kebijakan Operasional', 'Deskripsi' => 'Mitigasi risiko fluktuasi valas, suku bunga, likuiditas, dan risiko kredit mitra.', 'FileSize' => '780 KB', 'Urutan' => 8],
            ['Judul' => 'Kebijakan Anti Korupsi & Anti Penyuapan (ISO 37001)', 'Kategori' => 'Kebijakan Operasional', 'Deskripsi' => 'Sistem Manajemen Anti Penyuapan (SMAP) berstandar internasional ISO 37001.', 'FileSize' => '1.4 MB', 'Urutan' => 9],
            ['Judul' => 'Kebijakan Seleksi Pemasok & Hak Kreditor', 'Kategori' => 'Kebijakan Operasional', 'Deskripsi' => 'Transparansi pengadaan, verifikasi kapasitas vendor, dan pemenuhan hak kreditor tepat waktu.', 'FileSize' => '650 KB', 'Urutan' => 10],
        ];

        foreach ($dokumenData as $item) {
            DokumenTataKelola::firstOrCreate(
                ['Judul' => $item['Judul']],
                array_merge($item, ['Status' => 'Aktif', 'UserCreate' => 'System'])
            );
        }

        // 8. Dokumen RUPS
        $rupsList = [
            ['Tahun' => 2024, 'Judul' => 'Ringkasan Risalah RUPS Tahunan 2024', 'KategoriDokumen' => 'Ringkasan Risalah', 'StatusKegiatan' => 'Selesai', 'FileSize' => '1.1 MB', 'Urutan' => 1],
            ['Tahun' => 2024, 'Judul' => 'Pemberitahuan Pelaksanaan RUPS Tahunan 2024', 'KategoriDokumen' => 'Pemberitahuan', 'StatusKegiatan' => 'Selesai', 'FileSize' => '450 KB', 'Urutan' => 2],
            ['Tahun' => 2024, 'Judul' => 'Panggilan RUPS Tahunan Buku 2023', 'KategoriDokumen' => 'Panggilan', 'StatusKegiatan' => 'Selesai', 'FileSize' => '620 KB', 'Urutan' => 3],
            ['Tahun' => 2024, 'Judul' => 'Riwayat Hidup Kandidat Manajemen Perseroan', 'KategoriDokumen' => 'CV Manajemen', 'StatusKegiatan' => 'Selesai', 'FileSize' => '980 KB', 'Urutan' => 4],
            ['Tahun' => 2024, 'Judul' => 'Surat Kuasa Pemegang Saham RUPS 2024', 'KategoriDokumen' => 'Surat Kuasa', 'StatusKegiatan' => 'Selesai', 'FileSize' => '320 KB', 'Urutan' => 5],
        ];

        foreach ($rupsList as $item) {
            RupsDokumen::firstOrCreate(
                ['Judul' => $item['Judul'], 'Tahun' => $item['Tahun']],
                array_merge($item, ['Status' => 'Aktif', 'UserCreate' => 'System'])
            );
        }

        // 9. Lembaga Penunjang Pasar Modal
        $lembagaList = [
            [
                'NamaInstitusi' => 'Paul Hadiwinata, Hidajat Arsono, Retno Palilingan & Rekan',
                'Kategori' => 'Kantor Akuntan Publik (KAP)',
                'Afiliasi' => 'Anggota Firma PKF International Limited',
                'Website' => 'https://pkf.co.id',
                'KantorPusat' => "Jl. Kebon Sirih Timur I No. 287, Menteng, Jakarta 10340\nTelepon: (021) 3144550\nFaksimili: (021) 3144213, 3144550",
                'Cabang' => "Jl. Ngagel Jaya No. 89, Surabaya\nTelepon: (031) 5012181\nFaksimili: (031) 5012335",
                'Layanan' => 'Audit Laporan Keuangan Tahunan & Evaluasi Kepatuhan',
                'Urutan' => 1
            ],
            [
                'NamaInstitusi' => 'PT Bima Registra',
                'Kategori' => 'Biro Administrasi Efek (BAE)',
                'Afiliasi' => 'Penyedia Jasa Registrasi Efek & Administrasi Saham Perusahaan',
                'Website' => 'https://bimaregistra.co.id',
                'KantorPusat' => "Satrio Tower Lantai 9, Zona A2, Jl. Prof. Dr. Satrio Blok C4, Kuningan, Setiabudi, Jakarta Selatan 12950\nTelepon: (021) 2598 4818\nFaksimili: (021) 2598 4820",
                'Cabang' => null,
                'Layanan' => 'Pemutakhiran DPS Saham & Administrasi Daftar Pemegang Saham',
                'Urutan' => 2
            ],
        ];

        foreach ($lembagaList as $item) {
            LembagaPenunjang::firstOrCreate(
                ['NamaInstitusi' => $item['NamaInstitusi']],
                array_merge($item, ['Status' => 'Aktif', 'UserCreate' => 'System'])
            );
        }

        // 10. Keterbukaan Informasi & Pengumuman Material
        $keterbukaanList = [
            [
                'Judul' => '28 April 2024 - Keterbukaan Informasi atau Fakta Material',
                'Kategori' => 'Fakta Material',
                'TanggalPublikasi' => '2024-04-28',
                'Deskripsi' => 'Keterbukaan informasi terkait perolehan kontrak strategis sistem identifikasi dan paspor elektronik terintegrasi.',
                'FileSize' => '1.2 MB',
                'Urutan' => 1
            ],
            [
                'Judul' => '22 April 2024 - Keterbukaan Informasi Rencana Pembelian Kembali Saham (Share Buyback)',
                'Kategori' => 'Buyback Saham',
                'TanggalPublikasi' => '2024-04-22',
                'Deskripsi' => 'Rencana pembelian kembali saham beredar Perseroan sesuai POJK No. 29/POJK.04/2023 guna menjaga stabilitas volume pasar.',
                'FileSize' => '890 KB',
                'Urutan' => 2
            ],
            [
                'Judul' => '09 Desember 2023 - Keterbukaan Informasi Rencana Buyback Saham Dalam Kondisi Pasar Berfluktuasi Signifikan',
                'Kategori' => 'Aksi Korporasi',
                'TanggalPublikasi' => '2023-12-09',
                'Deskripsi' => 'Pengumuman rencana pembelian kembali saham dalam kondisi pasar yang berfluktuasi secara signifikan tanpa persetujuan RUPS.',
                'FileSize' => '720 KB',
                'Urutan' => 3
            ],
            [
                'Judul' => '13 November 2024 - Pembagian Dividen Tunai Interim Tahun Buku 2024',
                'Kategori' => 'Dividen',
                'TanggalPublikasi' => '2024-11-13',
                'Deskripsi' => 'Jadwal dan tata cara pembagian dividen tunai interim tahun buku 2024 kepada pemegang saham yang tercatat dalam DPS.',
                'FileSize' => '540 KB',
                'Urutan' => 4
            ],
            [
                'Judul' => '05 Agustus 2024 - Buletin Investor Agustus 2024',
                'Kategori' => 'Buletin Investor',
                'TanggalPublikasi' => '2024-08-05',
                'Deskripsi' => 'Penjelasan performa finansial semester I 2024, aktivasi lini produksi smart card, dan portofolio ke ekspansi pasar ekspor.',
                'FileSize' => '2.1 MB',
                'Urutan' => 5
            ],
            [
                'Judul' => '06 Mei 2024 - Buletin Investor Kuartal 1 2024',
                'Kategori' => 'Buletin Investor',
                'TanggalPublikasi' => '2024-05-06',
                'Deskripsi' => 'Ikhtisar operasional kuartal pertama 2024 serta realisasi pengadaan dokumen sekuriti perbankan komersial.',
                'FileSize' => '1.8 MB',
                'Urutan' => 6
            ],
        ];

        foreach ($keterbukaanList as $item) {
            KeterbukaanInformasi::firstOrCreate(
                ['Judul' => $item['Judul']],
                array_merge($item, ['Status' => 'Aktif', 'UserCreate' => 'System'])
            );
        }
    }
}
