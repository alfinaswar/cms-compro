<?php

namespace App\Http\Controllers;

use App\Models\JenisLaporanKeuangan;
use App\Models\LaporanKeuanganDetail;
use App\Models\InformasiSaham;
use App\Models\StrukturKepemilikan;
use App\Models\SkemaPengendali;
use App\Models\EntitasAnak;
use App\Models\BaganOrganisasi;
use App\Models\ManajemenTataKelola;
use App\Models\DokumenTataKelola;
use App\Models\RupsDokumen;
use App\Models\WbsLaporan;
use App\Models\LembagaPenunjang;
use App\Models\KeterbukaanInformasi;
use App\Models\MasterKantor;
use App\Models\PermintaanDokumenInvestor;
use App\Models\RingkasanKinerjaPos;
use App\Models\RingkasanKinerjaNilai;
use App\Models\PengaturanKinerjaKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvestorFrontendController extends Controller
{
    /**
     * Tab 1: Laporan Keuangan
     */
    public function laporanKeuangan($locale = 'id')
    {
        $categories = JenisLaporanKeuangan::where('Status', 'Aktif')
            ->orderBy('Urutan', 'asc')
            ->with([
                'details' => function ($query) {
                    $query->where('Status', 'Aktif')
                        ->orderBy('TahunPeriode', 'desc')
                        ->orderBy('Urutan', 'asc');
                },
                'allDetails'
            ])
            ->get();

        $availableYears = LaporanKeuanganDetail::where('Status', 'Aktif')
            ->selectRaw('YEAR(TahunPeriode) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $activeTab = 'laporan-keuangan';

        $prospektus = $categories->firstWhere('Slug', 'prospektus')?->details ?? collect();
        $annualReports = $categories->firstWhere('Slug', 'annual-report')?->details ?? collect();
        $quarterlyReports = $categories->firstWhere('Slug', 'quarterly-report')?->details ?? collect();

        // Dynamic Multi-Year Financial Summary Dataset (Normalized Schema)
        $pengaturanKinerja = PengaturanKinerjaKeuangan::firstOrCreate(
            ['id' => 1],
            [
                'ModeWindow' => 'Kustom',
                'JumlahTahun' => 5,
                'TahunMulai' => 2021,
                'TahunSelesai' => 2025,
                'PertumbuhanRevenue' => '+31.5% YoY (2025)',
                'PertumbuhanProfit' => '+47.7% YoY (2025)',
                'Subjudul' => 'Ringkasan kinerja keuangan utama perusahaan selama 5 tahun terakhir (2021 - 2025).',
                'UserCreate' => 'System',
            ]
        );

        $financialYears = $pengaturanKinerja->getActiveYears();

        $kinerjaRows = RingkasanKinerjaPos::with('nilais')->orderBy('Urutan', 'asc')->get();
        $labaRugi = $kinerjaRows->where('Kategori', 'Laba Rugi');
        $posisiKeuangan = $kinerjaRows->where('Kategori', 'Posisi Keuangan');
        $rasioKeuangan = $kinerjaRows->where('Kategori', 'Rasio');
        $sahamDividen = $kinerjaRows->where('Kategori', 'Saham & Dividen');

        // Chart values automatically extracted via KodePos
        $revenuePos = $kinerjaRows->firstWhere('KodePos', 'pendapatan_usaha')
            ?? $kinerjaRows->firstWhere('NamaPos', 'Pendapatan Usaha');
        $profitPos = $kinerjaRows->firstWhere('KodePos', 'laba_bersih')
            ?? $kinerjaRows->firstWhere('NamaPos', 'Laba Bersih Tahun Berjalan');

        $chartRevenue = [];
        $chartProfit = [];
        foreach ($financialYears as $yr) {
            $rawRev = $revenuePos ? (float) $revenuePos->nilaiAngkaTahun($yr) : 0;
            // Konversi dari Jutaan IDR ke Miliar IDR (bagi 1.000) untuk tampilan grafik
            $chartRevenue[] = $rawRev > 10000 ? round($rawRev / 1000, 1) : $rawRev;

            $rawProf = $profitPos ? (float) $profitPos->nilaiAngkaTahun($yr) : 0;
            $chartProfit[] = $rawProf > 10000 ? round($rawProf / 1000, 1) : $rawProf;
        }
        $kantor = MasterKantor::orderByRaw("FIELD(TipeKantor, 'Pusat') DESC")->first();

        // dd($annualReports);
        return view('frontend.laporan-keuangan', compact(
            'categories',
            'availableYears',
            'activeTab',
            'prospektus',
            'annualReports',
            'quarterlyReports',
            'financialYears',
            'chartRevenue',
            'chartProfit',
            'pengaturanKinerja',
            'kinerjaRows',
            'labaRugi',
            'posisiKeuangan',
            'rasioKeuangan',
            'sahamDividen',
            'kantor'
        ));
    }

    /**
     * Tab 2: Informasi Finansial (Figma Node 290:9781)
     */
    public function informasiFinansial($locale = 'id')
    {
        $saham = InformasiSaham::first() ?? new InformasiSaham([
            'KodeSaham' => 'JTPE',
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
        ]);

        // 12 Bulan Standar
        $daftarBulan = [
            'Januari' => 'Januari',
            'Februari' => 'Februari',
            'Maret' => 'Maret',
            'April' => 'April',
            'Mei' => 'Mei',
            'Juni' => 'Juni',
            'Juli' => 'Juli',
            'Agustus' => 'Agustus',
            'September' => 'September',
            'Oktober' => 'Oktober',
            'November' => 'November',
            'Desember' => 'Desember',
        ];

        $daftarBulanEn = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        // Daftar tahun descending
        $dbYears = StrukturKepemilikan::where('Status', 'Aktif')
            ->whereNotNull('PeriodeTahun')
            ->select('PeriodeTahun')
            ->distinct()
            ->pluck('PeriodeTahun')
            ->toArray();

        $allYears = array_unique(array_merge($dbYears, ['2026', '2025', '2024']));
        rsort($allYears);
        $periodeTahunList = collect($allYears);

        // Cari record terakhir yang ada di database untuk default
        $latestRecord = StrukturKepemilikan::where('Status', 'Aktif')
            ->orderBy('PeriodeTahun', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $selectedTahunKepemilikan = request('tahun_kepemilikan', $latestRecord?->PeriodeTahun ?? ($periodeTahunList->first() ?? '2024'));
        $selectedBulanKepemilikan = request('bulan_kepemilikan', $latestRecord?->PeriodeBulan ?? 'Maret');

        $strukturNasional = StrukturKepemilikan::where('Status', 'Aktif')
            ->where('TipePemodal', 'Pemodal Nasional')
            ->where('PeriodeTahun', $selectedTahunKepemilikan)
            ->where('PeriodeBulan', $selectedBulanKepemilikan)
            ->orderBy('Urutan', 'asc')
            ->get();

        $strukturAsing = StrukturKepemilikan::where('Status', 'Aktif')
            ->where('TipePemodal', 'Pemodal Asing')
            ->where('PeriodeTahun', $selectedTahunKepemilikan)
            ->where('PeriodeBulan', $selectedBulanKepemilikan)
            ->orderBy('Urutan', 'asc')
            ->get();

        $totalNasionalSaham = $strukturNasional->sum('JumlahSaham');
        $totalNasionalPersen = $strukturNasional->sum('Persentase');

        $totalAsingSaham = $strukturAsing->sum('JumlahSaham');
        $totalAsingPersen = $strukturAsing->sum('Persentase');

        $totalModalDisetor = $totalNasionalSaham + $totalAsingSaham;

        $skema = SkemaPengendali::first() ?? new SkemaPengendali();

        $entitasAnak = EntitasAnak::where('Status', 'Aktif')
            ->orderBy('TahunBergabung', 'asc')
            ->orderBy('Urutan', 'asc')
            ->get();

        $activeTab = 'informasi-finansial';

        return view('frontend.investor.informasi-finansial', compact(
            'saham',
            'strukturNasional',
            'strukturAsing',
            'totalNasionalSaham',
            'totalNasionalPersen',
            'totalAsingSaham',
            'totalAsingPersen',
            'totalModalDisetor',
            'skema',
            'entitasAnak',
            'activeTab',
            'daftarBulan',
            'daftarBulanEn',
            'periodeTahunList',
            'selectedTahunKepemilikan',
            'selectedBulanKepemilikan'
        ));
    }

    /**
     * Tab 3: Tata Kelola Perusahaan (Figma Node 290:7981)
     */
    public function tataKelola($locale = 'id')
    {
        $bagan = BaganOrganisasi::first() ?? new BaganOrganisasi([
            'Judul' => 'Bagan Struktur Organisasi Perseroan',
            'TanggalDiperbarui' => '2024-06-02',
            'EmailSekretariat' => 'corsec@jasuindo.com',
            'TeleponSekretariat' => '+62 31 891 0619',
            'AlamatSekretariat' => "Jl. Raya Betro No. 21, Sedati, Sidoarjo 61253",
            'Keterangan' => 'Memastikan efektivitas pembagian tugas yang terarah, akuntabilitas yang jelas, serta pemisahan independen antara fungsi pengawasan dan fungsi eksekutif.',
        ]);

        $komisaris = ManajemenTataKelola::where('Status', 'Aktif')
            ->where('Kategori', 'Dewan Komisaris')
            ->orderBy('Urutan', 'asc')
            ->get();

        $direksi = ManajemenTataKelola::where('Status', 'Aktif')
            ->where('Kategori', 'Direksi Perseroan')
            ->orderBy('Urutan', 'asc')
            ->get();

        $dokumenGcg = DokumenTataKelola::where('Status', 'Aktif')
            ->where('Kategori', 'Dokumen Tata Kelola')
            ->orderBy('Urutan', 'asc')
            ->get();

        $kebijakan = DokumenTataKelola::where('Status', 'Aktif')
            ->where('Kategori', 'Kebijakan Operasional')
            ->orderBy('Urutan', 'asc')
            ->get();

        $komiteAudit = DokumenTataKelola::where('Status', 'Aktif')
            ->whereIn('Kategori', ['Komite Audit', 'Satuan Audit Internal'])
            ->orderBy('Urutan', 'asc')
            ->get();

        // RUPS Grouped by Year
        $rupsTahun = RupsDokumen::where('Status', 'Aktif')
            ->select('Tahun')
            ->distinct()
            ->orderBy('Tahun', 'desc')
            ->pluck('Tahun');

        $selectedTahun = request('tahun_rups', $rupsTahun->first() ?? 2024);

        $rupsDokumen = RupsDokumen::where('Status', 'Aktif')
            ->where('Tahun', $selectedTahun)
            ->orderBy('Urutan', 'asc')
            ->get();

        $activeTab = 'tata-kelola';
        $kantor = MasterKantor::orderByRaw("FIELD(TipeKantor, 'Pusat') DESC")->first();

        return view('frontend.investor.tata-kelola', compact(
            'bagan',
            'komisaris',
            'direksi',
            'dokumenGcg',
            'kebijakan',
            'komiteAudit',
            'rupsTahun',
            'selectedTahun',
            'rupsDokumen',
            'activeTab',
            'kantor'
        ));
    }

    /**
     * Tab 4: Informasi Lainnya (Figma Node 290:7477)
     */
    public function informasiLainnya($locale = 'id')
    {
        $lembagaList = LembagaPenunjang::where('Status', 'Aktif')
            ->orderBy('Urutan', 'asc')
            ->get();

        $keterbukaanQuery = KeterbukaanInformasi::where('Status', 'Aktif')
            ->orderBy('TanggalPublikasi', 'desc')
            ->orderBy('Urutan', 'asc');

        if (request()->filled('q')) {
            $keterbukaanQuery->where(function ($q) {
                $q->where('Judul', 'like', '%' . request('q') . '%')
                    ->orWhere('Deskripsi', 'like', '%' . request('q') . '%');
            });
        }

        if (request()->filled('kategori') && request('kategori') !== 'all') {
            $keterbukaanQuery->where('Kategori', request('kategori'));
        }

        if (request()->filled('tahun') && request('tahun') !== 'all') {
            $keterbukaanQuery->whereYear('TanggalPublikasi', request('tahun'));
        }

        $keterbukaanList = $keterbukaanQuery->paginate(6)->withQueryString();

        $kategoriList = KeterbukaanInformasi::where('Status', 'Aktif')
            ->select('Kategori')
            ->distinct()
            ->pluck('Kategori');

        $tahunList = KeterbukaanInformasi::where('Status', 'Aktif')
            ->selectRaw('YEAR(TanggalPublikasi) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $activeTab = 'informasi-lainnya';

        $kantor = MasterKantor::orderByRaw("FIELD(TipeKantor, 'Pusat') DESC")->first();
        return view('frontend.investor.informasi-lainnya', compact(
            'lembagaList',
            'keterbukaanList',
            'kategoriList',
            'tahunList',
            'activeTab',
            'kantor'
        ));
    }

    /**
     * Submit WBS Report
     */
    public function submitWbs(Request $request, $locale = 'id')
    {
        $validated = $request->validate([
            'KategoriPelanggaran' => 'required|string|max:255',
            'Terlapor' => 'nullable|string|max:255',
            'WaktuKejadian' => 'nullable|date',
            'LokasiKejadian' => 'nullable|string|max:255',
            'UraianKejadian' => 'required|string',
            'NamaPelapor' => 'nullable|string|max:255',
            'EmailPelapor' => 'nullable|email|max:255',
            'TeleponPelapor' => 'nullable|string|max:50',
            'BuktiFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        if ($request->hasFile('BuktiFile')) {
            // Simpan di disk private 'local' agar tidak terekspos di public storage
            $validated['PathBukti'] = $request->file('BuktiFile')->store('wbs-bukti', 'local');
        }

        $validated['NomorTiket'] = 'WBS-' . date('Ymd') . '-' . strtoupper(Str::random(5));
        $validated['StatusLaporan'] = 'Menunggu Review';
        $validated['UserCreate'] = $validated['NamaPelapor'] ?? 'Pelapor Anonim';

        WbsLaporan::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan Whistleblowing System (WBS) Anda berhasil dikirim dengan Nomor Tiket: ' . $validated['NomorTiket'] . '. Kerahasiaan identitas Anda terjamin.',
            'nomor_tiket' => $validated['NomorTiket']
        ]);
    }

    /**
     * Submit Physical Document Request
     */
    public function submitPermintaanDokumen(Request $request, $locale = 'id')
    {
        $validated = $request->validate([
            'Nama' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'Institusi' => 'nullable|string|max:255',
            'Telepon' => 'nullable|string|max:50',
            'JenisDokumen' => 'required|string|max:255',
            'AlamatPengiriman' => 'required|string',
            'Catatan' => 'nullable|string',
        ]);

        $validated['StatusPermintaan'] = 'Pending';
        $validated['UserCreate'] = $validated['Nama'];

        PermintaanDokumenInvestor::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Permintaan salinan fisik dokumen telah diterima. Tim Hubungan Investor akan memverifikasi dan memproses pengiriman.'
        ]);
    }
}
