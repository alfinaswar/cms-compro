<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\AboutUsDetail;
use App\Models\AboutUsDetailTranslation;
use App\Models\AboutUsTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tentang-kami.view')->only(['index']);
        $this->middleware('permission:tentang-kami.create')->only(['create', 'store']);
        $this->middleware('permission:tentang-kami.edit')->only(['edit', 'update']);
        $this->middleware('permission:tentang-kami.delete')->only(['destroy']);
    }

    /**
     * Section tetap halaman About (ID = baris di about_us).
     * Detail tiap section disimpan di about_us_details.
     */
    public const SECTIONS = [
        5 => [
            'key' => 'hero',
            'label' => 'Hero',
            'hint' => 'Judul baris 1, Sub Judul = teks biru baris 2, Deskripsi = paragraf. Detail = statistik (Judul=nilai, Deskripsi=label|||keterangan).',
            'detail_labels' => ['Judul' => 'Nilai', 'Deskripsi' => 'Label|||Keterangan'],
        ],
        1 => [
            'key' => 'profil',
            'label' => 'Profil & Timeline',
            'hint' => 'Header sejarah perusahaan. Detail = timeline (Judul=tahun, Deskripsi=judul peristiwa|||deskripsi).',
            'detail_labels' => ['Judul' => 'Tahun', 'Deskripsi' => 'Judul|||Deskripsi'],
        ],
        6 => [
            'key' => 'media',
            'label' => 'Video & Quote',
            'hint' => 'Gambar = thumbnail video. Judul = judul video. Sub Judul = judul quote. Deskripsi = teks quote. Meta URL & atribut diisi di form khusus.',
            'detail_labels' => null,
            'meta_keys' => [
                'video_badge' => 'Badge Video',
                'video_tagline' => 'Tagline Video',
                'video_url' => 'URL Video',
                'pdf_url' => 'URL Download PDF',
                'quote_subtitle' => 'Sub Judul Quote',
                'quote_author' => 'Penulis Quote',
                'quote_company' => 'Perusahaan Quote',
            ],
        ],
        2 => [
            'key' => 'nilai',
            'label' => 'Nilai Inti',
            'hint' => 'Header section nilai. Detail = kartu nilai (Gambar = upload icon ATAU isi class FontAwesome di kolom Icon FA, mis. fa-solid fa-gem).',
            'detail_labels' => ['Judul' => 'Judul Nilai', 'Deskripsi' => 'Deskripsi', 'has_icon' => true],
        ],
        3 => [
            'key' => 'csr',
            'label' => 'CSR',
            'hint' => 'Header section CSR. Detail = kartu CSR (Gambar, Judul, Deskripsi).',
            'detail_labels' => ['Judul' => 'Judul CSR', 'Deskripsi' => 'Deskripsi'],
        ],
        4 => [
            'key' => 'award',
            'label' => 'Penghargaan',
            'hint' => 'Header section penghargaan. Detail = kartu sertifikasi/penghargaan.',
            'detail_labels' => ['Judul' => 'Nama', 'Deskripsi' => 'Deskripsi'],
        ],
        7 => [
            'key' => 'iso',
            'label' => 'ISO Suite',
            'hint' => 'Judul & Sub Judul panel ISO. Detail = daftar ISO (Judul=nama ISO, Deskripsi=keterangan).',
            'detail_labels' => ['Judul' => 'Nama ISO', 'Deskripsi' => 'Keterangan'],
        ],
        8 => [
            'key' => 'cta',
            'label' => 'CTA',
            'hint' => 'Sub Judul = badge, Judul = headline, Deskripsi = paragraf CTA. Detail opsional = tombol (Judul=label, Deskripsi=URL).',
            'detail_labels' => ['Judul' => 'Label Tombol', 'Deskripsi' => 'URL'],
        ],
    ];

    /**
     * Halaman admin terpadu — semua section About di satu form bertab.
     */
    public function index()
    {
        $sections = $this->ensureSections();

        return view('pengaturan.landing-page.about.manage', [
            'sections' => $sections,
            'sectionConfig' => self::SECTIONS,
            'locales' => ['id' => '🇮🇩 Bahasa Indonesia', 'en' => '🇬🇧 English'],
        ]);
    }

    public function create()
    {
        return redirect()->route('about-us.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('about-us.index');
    }

    /**
     * Frontend halaman About.
     */
    public function show()
    {
        $locale = app()->getLocale();
        $ids = array_keys(self::SECTIONS);
        $loaded = AboutUs::with(['getDetail.translations', 'translations'])
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        $Hero = $loaded[5] ?? null;
        $Riwayat = $loaded[1] ?? null;
        $Media = $loaded[6] ?? null;
        $Value = $loaded[2] ?? null;
        $TanggungJawab = $loaded[3] ?? null;
        $Award = $loaded[4] ?? null;
        $Iso = $loaded[7] ?? null;
        $Cta = $loaded[8] ?? null;

        $mediaMeta = $this->extractMeta($Media, self::SECTIONS[6]['meta_keys'] ?? []);

        // Helper closure untuk akses translation per section di view
        $t = function ($section) use ($locale) {
            return $section ? $section->translate($locale) : null;
        };

        return view('frontend.about', compact(
            'Hero',
            'Riwayat',
            'Media',
            'mediaMeta',
            'Value',
            'TanggungJawab',
            'Award',
            'Iso',
            'Cta',
            'locale',
            't'
        ));
    }

    public function edit($id)
    {
        return redirect()->route('about-us.index');
    }

    /**
     * Simpan semua section sekaligus.
     */
    public function update(Request $request)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.translations' => 'required|array',
            'sections.*.translations.*.SubJudul' => 'nullable|string|max:500',
            'sections.*.translations.*.Judul' => 'nullable|string|max:500',
            'sections.*.translations.*.Deskripsi' => 'nullable|string',
            'sections.*.Gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'sections.*.details' => 'nullable|array',
            'sections.*.meta' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $logs = [];

            foreach ($request->input('sections', []) as $sectionId => $data) {
                $sectionId = (int) $sectionId;
                if (!isset(self::SECTIONS[$sectionId]))
                    continue;

                $about = AboutUs::findOrFail($sectionId);
                $oldSection = $about->only(['SubJudul', 'Judul', 'Deskripsi', 'Gambar']);

                // Handle Gambar section (tetap single, tidak di-translate)
                $gambarPath = $about->Gambar;
                if ($request->hasFile("sections.{$sectionId}.Gambar")) {
                    if ($gambarPath && Storage::disk('public')->exists($gambarPath)) {
                        Storage::disk('public')->delete($gambarPath);
                    }
                    $gambarPath = $request->file("sections.{$sectionId}.Gambar")->store('about-us', 'public');
                }

                // Simpan ke kolom lama (fallback ke bahasa Indonesia)
                $idTrans = $data['translations']['id'] ?? [];
                $about->update([
                    'SubJudul' => $idTrans['SubJudul'] ?? null,
                    'Judul' => $idTrans['Judul'] ?? null,
                    'Deskripsi' => $idTrans['Deskripsi'] ?? null,
                    'Gambar' => $gambarPath,
                    'UserUpdate' => auth()->check() ? auth()->user()->name : null,
                ]);

                // Simpan ke tabel translations untuk setiap locale
                foreach ($data['translations'] as $locale => $trans) {
                    AboutUsTranslation::updateOrCreate(
                        ['IdAbout' => $about->id, 'Locale' => $locale],
                        [
                            'SubJudul' => $trans['SubJudul'] ?? null,
                            'Judul' => $trans['Judul'] ?? null,
                            'Deskripsi' => $trans['Deskripsi'] ?? null,
                        ]
                    );
                }

                $config = self::SECTIONS[$sectionId];
                $beforeDetails = [];
                $afterDetails = [];

                if (!empty($config['meta_keys'])) {
                    $beforeDetails = $this->extractMeta($about, $config['meta_keys']);
                    $this->syncMetaDetails($about, $data['meta'] ?? [], $config['meta_keys']);
                    $about->refresh();
                    $afterDetails = $this->extractMeta($about, $config['meta_keys']);
                } else {
                    $beforeDetails = AboutUsDetail::where('IdAbout', $about->id)->get()->toArray();
                    $this->syncDetails($about, $data['details'] ?? [], $request, $sectionId);
                    $afterDetails = AboutUsDetail::where('IdAbout', $about->id)->with('translations')->get()->toArray();
                }

                $logs[] = [
                    'section_id' => $sectionId,
                    'section_key' => $config['key'],
                    'changes' => [
                        'attributes' => ['before' => $oldSection, 'after' => $about->only(['SubJudul', 'Judul', 'Deskripsi', 'Gambar'])],
                        'translations' => $data['translations'],
                        'details' => ['before' => $beforeDetails, 'after' => $afterDetails],
                    ]
                ];
            }

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['changes' => $logs])
                ->log('Memperbarui konten halaman Tentang Kami (multi-bahasa)');

            DB::commit();
            return redirect()->route('about-us.index')->with('success', 'Konten Tentang Kami berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        return response()->json(['success' => 'Penghapusan section tidak diizinkan.'], 403);
    }

    /**
     * Pastikan 8 baris section selalu ada.
     */
    protected function ensureSections(): array
    {
        $defaults = [
            5 => ['SubJudul' => 'Kredensial Identitas & Dokumen Sekuritas Digital', 'Judul' => 'Menjaga Kepercayaan, Mengembangkan', 'Deskripsi' => 'Pelopor manufaktur dokumen sekuritas resmi negara, infrastruktur chip perbankan EMV, autentikasi merek kriptografis, dan solusi smart card terintegrasi di kawasan Asia Tenggara sejak 1990.'],
            1 => ['SubJudul' => 'Presisi dan Rekam Jejak', 'Judul' => 'Sejarah Singkat Perusahaan', 'Deskripsi' => null],
            6 => ['SubJudul' => 'Pesan Dewan Direksi', 'Judul' => 'Memacu Kinerja Bisnis', 'Deskripsi' => '"Komitmen kami berakar pada penyediaan keamanan mutlak bagi pemerintah berdaulat, perbankan, dan mitra korporasi global melalui keandalan tanpa kompromi. Melalui inovasi berkelanjutan dan aliansi bersama Toppan Printing Jepang, Jasuindo senantiasa memimpin transformasi paradigma keamanan identitas masa depan."'],
            2 => ['SubJudul' => 'Matriks Panduan Kerja', 'Judul' => 'Nilai–Nilai Utama Perusahaan', 'Deskripsi' => null],
            3 => ['SubJudul' => 'Dampak Berkelanjutan', 'Judul' => 'Tanggung Jawab Sosial Perusahaan', 'Deskripsi' => null],
            4 => ['SubJudul' => 'Otoritas & Kepatuhan Global Terintegrasi', 'Judul' => 'Penghargaan & Sertifikasi Berstandar Keamanan Tinggi', 'Deskripsi' => null],
            7 => ['SubJudul' => 'Terakreditasi oleh INTERGRAF, TÜV NORD, Assurance Quality Certification, dan QFS', 'Judul' => 'ISO Certification Suite (Rangkaian ISO Lengkap)', 'Deskripsi' => 'Badan Sertifikasi: INTERGRAF, TÜV NORD, Assurance Quality & QFS'],
            8 => ['SubJudul' => 'Meja Layanan Pemerintah Berdaulat & Enterprise', 'Judul' => 'Mitra Strategis Penyedia Kredensial & Dokumen Sekuritas Terdepan di Asia Tenggara', 'Deskripsi' => 'Konsultasikan kebutuhan spesifik organisasi Anda bersama tim ahli kami — mulai dari e-Paspor kenegaraan, solusi kartu perbankan, segel hologram terenkripsi, hingga percetakan dokumen sekuritas berstandar tinggi.'],
        ];

        $result = [];
        foreach (self::SECTIONS as $id => $config) {
            $about = AboutUs::with('getDetail')->find($id);
            if (!$about) {
                $payload = array_merge($defaults[$id] ?? [
                    'SubJudul' => null,
                    'Judul' => $config['label'],
                    'Deskripsi' => null,
                ], [
                    'id' => $id,
                    'Gambar' => null,
                    'UserCreate' => auth()->check() ? auth()->user()->name : 'system',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('about_us')->insert($payload);
                $about = AboutUs::with('getDetail')->find($id);
            }
            $result[$id] = $about;
        }

        return $result;
    }

    protected function extractMeta(?AboutUs $about, array $metaKeys): array
    {
        $meta = array_fill_keys(array_keys($metaKeys), null);
        if (!$about) {
            return $meta;
        }

        foreach ($about->getDetail as $detail) {
            if (array_key_exists($detail->Judul, $meta)) {
                $meta[$detail->Judul] = $detail->Deskripsi;
            }
        }

        return $meta;
    }

    protected function syncMetaDetails(AboutUs $about, array $meta, array $metaKeys): void
    {
        foreach ($metaKeys as $key => $label) {
            $value = $meta[$key] ?? null;
            $existing = AboutUsDetail::where('IdAbout', $about->id)->where('Judul', $key)->first();

            if ($value === null || $value === '') {
                if ($existing) {
                    if ($existing->Gambar && Storage::disk('public')->exists($existing->Gambar)) {
                        Storage::disk('public')->delete($existing->Gambar);
                    }
                    $existing->delete();
                }
                continue;
            }

            if ($existing) {
                $existing->update(['Deskripsi' => $value]);
            } else {
                AboutUsDetail::create([
                    'IdAbout' => $about->id,
                    'Judul' => $key,
                    'Deskripsi' => $value,
                ]);
            }
        }

        // Hapus detail meta lama yang tidak lagi di daftar keys
        AboutUsDetail::where('IdAbout', $about->id)
            ->whereNotIn('Judul', array_keys($metaKeys))
            ->delete();
    }

    protected function syncDetails(AboutUs $about, array $details, Request $request, int $sectionId): void
    {
        $keepIds = [];

        foreach ($details as $index => $detail) {
            $translations = $detail['translations'] ?? [];
            $idTrans = $translations['id'] ?? [];
            $enTrans = $translations['en'] ?? [];

            $judul = trim($idTrans['Judul'] ?? '');
            $deskripsi = $idTrans['Deskripsi'] ?? null;
            $iconFa = trim($detail['IconFa'] ?? '');

            // Skip baris kosong
            $hasAnyContent = !empty($judul) || !empty($deskripsi) || !empty($iconFa);
            foreach ($translations as $t) {
                if (!empty(trim($t['Judul'] ?? '')) || !empty($t['Deskripsi'] ?? '')) {
                    $hasAnyContent = true;
                    break;
                }
            }
            if (!$hasAnyContent && !$request->hasFile("sections.{$sectionId}.details.{$index}.Gambar")) {
                continue;
            }

            $detailId = $detail['id'] ?? null;
            $existing = $detailId ? AboutUsDetail::where('IdAbout', $about->id)->find($detailId) : null;
            $gambarPath = $existing?->Gambar;

            // Handle Icon FA vs upload gambar
            if ($iconFa !== '') {
                if ($gambarPath && !str_starts_with((string) $gambarPath, 'fa') && Storage::disk('public')->exists($gambarPath)) {
                    Storage::disk('public')->delete($gambarPath);
                }
                $gambarPath = $iconFa;
            } elseif ($request->hasFile("sections.{$sectionId}.details.{$index}.Gambar")) {
                if ($gambarPath && !str_starts_with((string) $gambarPath, 'fa') && Storage::disk('public')->exists($gambarPath)) {
                    Storage::disk('public')->delete($gambarPath);
                }
                $gambarPath = $request->file("sections.{$sectionId}.details.{$index}.Gambar")->store('about-us/details', 'public');
            }

            if ($existing) {
                $existing->update([
                    'Judul' => $judul ?: null,
                    'Deskripsi' => $deskripsi,
                    'Gambar' => $gambarPath,
                ]);
                $keepIds[] = $existing->id;
            } else {
                $created = AboutUsDetail::create([
                    'IdAbout' => $about->id,
                    'Judul' => $judul ?: null,
                    'Deskripsi' => $deskripsi,
                    'Gambar' => $gambarPath,
                ]);
                $existing = $created;
                $keepIds[] = $created->id;
            }

            // Simpan translations untuk setiap locale
            foreach ($translations as $locale => $trans) {
                AboutUsDetailTranslation::updateOrCreate(
                    ['IdAboutUsDetail' => $existing->id, 'Locale' => $locale],
                    [
                        'Judul' => $trans['Judul'] ?? null,
                        'Deskripsi' => $trans['Deskripsi'] ?? null,
                    ]
                );
            }
        }

        // Hapus detail yang tidak lagi ada di form
        $toDelete = AboutUsDetail::where('IdAbout', $about->id)
            ->when(count($keepIds), fn($q) => $q->whereNotIn('id', $keepIds))
            ->get();

        foreach ($toDelete as $row) {
            if ($row->Gambar && !str_contains((string) $row->Gambar, 'fa-') && Storage::disk('public')->exists($row->Gambar)) {
                Storage::disk('public')->delete($row->Gambar);
            }
            $row->delete();
        }
    }
}
