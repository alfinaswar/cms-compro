<?php

namespace App\Http\Controllers;

use App\Models\HalamanSolusi;
use App\Models\HalamanSolusiDetail;
use App\Models\HalamanSolusiSubpage;
use App\Models\HalamanSolusiSubpageItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Str;

class HalamanSolusiController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:solusi.view')->only(['index', 'show']);
        $this->middleware('permission:solusi.create')->only(['create', 'store']);
        $this->middleware('permission:solusi.edit')->only(['edit', 'update', 'editSub', 'updateSub']);
        $this->middleware('permission:solusi.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = HalamanSolusi::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Toggle', function ($row) {
                    return '<button type="button" class="btn btn-sm btn-light border btn-detail-toggle" title="Lihat Detail">
                            <i class="fa fa-chevron-down"></i>
                        </button>';
                })
                ->addColumn('Judul', function ($row) {
                    return $row->Judul;
                })
                ->addColumn('Slug', function ($row) {
                    $urlId = url('/id/solusi/' . $row->Slug);
                    return '<code>' . e($row->Slug) . '</code>
                    <div class="mt-1 small">
                        <a href="' . $urlId . '" target="_blank" class="badge badge-primary mr-1" title="Buka Versi ID">
                            <i class="fa fa-external-link-alt mr-1"></i>/id/solusi/' . e($row->Slug) . '
                        </a>
                    </div>';
                })
                ->addColumn('Konten', function ($row) {
                    return Str::limit(strip_tags($row->Konten), 100);
                })
                ->addColumn('Status', function ($row) {
                    return $row->IsPublished
                        ? '<span class="badge badge-success">Publikasi</span>'
                        : '<span class="badge badge-secondary">Draft</span>';
                })
                ->addColumn('DetailHtml', function ($row) {
                    return view('pages.admin.halaman-solusi.partials.detail-row', [
                        'row' => $row,
                        'kontenFull' => Str::limit(strip_tags($row->Konten), 800, '...'),
                        'editUrl' => route('halaman-solusi.edit', encrypt($row->id)),
                        'urlId' => url('/id/solusi/' . $row->Slug),
                        'urlEn' => url('/en/solusi/' . $row->Slug),
                    ])->render();
                })
                ->addColumn('action', function ($row) {
                    $encryptedId = encrypt($row->id);
                    $btn = '<div class="btn-group btn-group-sm">';
                    if (auth()->user()->can('solusi.view')) {
                        $btn .= '<a href="' . route('halaman-solusi.show', ['locale' => session('locale', 'id'), 'id' => $row->Slug]) . '" class="btn btn-info" title="Lihat di Web" target="_blank"><i class="fa fa-eye"></i></a>';
                    }
                    if (auth()->user()->can('solusi.edit')) {
                        $btn .= '<a href="' . route('halaman-solusi.edit', $encryptedId) . '" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>';
                    }
                    if (auth()->user()->can('solusi.delete')) {
                        $btn .= '<button class="btn btn-danger btn-delete" data-id="' . $encryptedId . '" title="Hapus"><i class="fa fa-trash"></i></button>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['Toggle', 'Slug', 'Status', 'action', 'DetailHtml']) // ✅ FIX DI SINI
                ->make(true);
        }

        return view('pages.admin.halaman-solusi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.halaman-solusi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Translations Utama
            'translations.id.Judul' => 'required|string|max:255',
            'translations.id.DeskripsiSingkat' => 'nullable|string',
            'translations.id.Konten' => 'required|string',
            'translations.id.SEOTitle' => 'nullable|string|max:70',
            'translations.id.SEODescription' => 'nullable|string|max:255',
            'translations.id.SEOKeywords' => 'nullable|string|max:255',
            'translations.en.Judul' => 'nullable|string|max:255',
            'translations.en.DeskripsiSingkat' => 'nullable|string',
            'translations.en.Konten' => 'nullable|string',
            'translations.en.SEOTitle' => 'nullable|string|max:70',
            'translations.en.SEODescription' => 'nullable|string|max:255',
            'translations.en.SEOKeywords' => 'nullable|string|max:255',
            // Data Umum
            'Slug' => 'nullable|string|max:255',
            'IsPublished' => 'required|in:0,1',
            'Thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            // Translations Detail
            'details' => 'required|array|min:1',
            'details.*.gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'details.*.translations.id.Judul' => 'required|string|max:255',
            'details.*.translations.id.Keterangan' => 'nullable|string',
            'details.*.translations.en.Judul' => 'nullable|string|max:255',
            'details.*.translations.en.Keterangan' => 'nullable|string',
            'faqs_main' => 'nullable|array',
            'faqs_main.*.translations.id.Pertanyaan' => 'nullable|string',
            'faqs_main.*.translations.id.Jawaban' => 'nullable|string',
            'faqs_main.*.translations.en.Pertanyaan' => 'nullable|string',
            'faqs_main.*.translations.en.Jawaban' => 'nullable|string',
        ]);

        // Helper: ubah faqs_main menjadi array [{id:[q,a], en:[q,a]}, ...]
        $buildFaqItems = function (array $faqsMain, string $locale) {
            return collect($faqsMain)->map(fn ($row) => [
                'q' => $row['translations'][$locale]['Pertanyaan'] ?? null,
                'a' => $row['translations'][$locale]['Jawaban'] ?? null,
            ])->filter(fn ($item) => $item['q'] || $item['a'])->values()->all();
        };

        // 1. Simpan Data Utama (fallback ke Bahasa Indonesia)
        $solusi = new HalamanSolusi();
        $solusi->Judul = $validated['translations']['id']['Judul'];
        $solusi->DeskripsiSingkat = $validated['translations']['id']['DeskripsiSingkat'] ?? null;
        $solusi->Konten = $validated['translations']['id']['Konten'];
        $solusi->FaqItems = !empty($request->faqs_main) ? $buildFaqItems($request->faqs_main, 'id') : null;
        $solusi->SEOTitle = $validated['translations']['id']['SEOTitle'] ?? null;
        $solusi->SEODescription = $validated['translations']['id']['SEODescription'] ?? null;
        $solusi->SEOKeywords = $validated['translations']['id']['SEOKeywords'] ?? null;

        // Auto-generate slug unik jika slug sudah ada di database
        $baseSlug = Str::slug($request->Slug ?: $solusi->Judul);
        $slug = $baseSlug;
        $counter = 1;
        while (HalamanSolusi::where('Slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $solusi->Slug = $slug;

        $solusi->IsPublished = $request->IsPublished;
        $solusi->UserCreate = auth()->user()->name;

        if ($request->hasFile('Thumbnail')) {
            $solusi->Thumbnail = $request->file('Thumbnail')->storeAs('halaman-solusi/thumbnail', $request->file('Thumbnail')->hashName(), 'public');
        }
        $solusi->save();

        // 2. Simpan Terjemahan Utama
        foreach (['id', 'en'] as $locale) {
            if (!empty($validated['translations'][$locale]['Judul'])) {
                $solusi->translations()->create([
                    'Locale' => $locale,
                    'Judul' => $validated['translations'][$locale]['Judul'] ?? null,
                    'DeskripsiSingkat' => $validated['translations'][$locale]['DeskripsiSingkat'] ?? null,
                    'Konten' => $validated['translations'][$locale]['Konten'] ?? null,
                    'FaqItems' => !empty($request->faqs_main) ? $buildFaqItems($request->faqs_main, $locale) : null,
                    'SEOTitle' => $validated['translations'][$locale]['SEOTitle'] ?? null,
                    'SEODescription' => $validated['translations'][$locale]['SEODescription'] ?? null,
                    'SEOKeywords' => $validated['translations'][$locale]['SEOKeywords'] ?? null,
                ]);
            }
        }

        // 3. Simpan Detail & Terjemahan Detail
        if (is_array($request->details)) {
            foreach ($request->details as $i => $det) {
                $detail = new HalamanSolusidetail();
                $detail->HalamanSolusiId = $solusi->id;

                if ($request->hasFile("details.$i.gambar")) {
                    $file = $request->file("details.$i.gambar");
                    $detail->Gambar = $file->storeAs('halaman-solusi/detail', $file->hashName(), 'public');
                }
                $detail->save();

                // Simpan terjemahan untuk detail ini
                foreach (['id', 'en'] as $locale) {
                    if (!empty($det['translations'][$locale]['Judul'])) {
                        $detail->translations()->create([
                            'Locale' => $locale,
                            'Judul' => $det['translations'][$locale]['Judul'] ?? null,
                            'Keterangan' => $det['translations'][$locale]['Keterangan'] ?? null,
                        ]);
                    }
                }
            }
        }

        activity()
            ->causedBy(auth()->user())
            ->performedOn($solusi)
            ->withProperties(['attributes' => $solusi->toArray()])
            ->log('Menambahkan halaman solusi baru: ' . ($solusi->Judul ?? ''));

        return redirect()->route('halaman-solusi.index')->with('success', 'Solusi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug, $id)
    {
        // dd($id);
        $halamanSolusi = HalamanSolusi::with([
            'details.translations',
            'details.subpage.items.translations',
            'translations',
        ])
            ->where('Slug', $id)
            ->orWhere('id', is_numeric($id) ? $id : null)
            ->firstOrFail();
        // dd($halamanSolusi);
        return view('pages.admin.halaman-solusi.show', compact('halamanSolusi'));
    }

    /**
     * Display a public sub-solution page (dari button "Subhalaman").
     */
    public function showSub($locale, $parentSlug, $subSlug)
    {
        $halamanSolusi = HalamanSolusi::with(['details.translations', 'translations'])
            ->where('Slug', $parentSlug)
            ->orWhere('id', is_numeric($parentSlug) ? $parentSlug : null)
            ->firstOrFail();

        // Cari subpage yang dipublikasikan milik detail pada solusi induk ini
        $subpage = HalamanSolusiSubpage::with(['translations', 'items.translations', 'detail.translations'])
            ->where('Slug', $subSlug)
            ->where('IsPublished', true)
            ->whereHas('detail', function ($q) use ($halamanSolusi) {
                $q->where('HalamanSolusiId', $halamanSolusi->id)
                    ->whereNull('halaman_solusi_details.deleted_at');
            })
            ->firstOrFail();

        return view('pages.admin.halaman-solusi.show-sub', compact('halamanSolusi', 'subpage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $data = HalamanSolusi::with('details')->find($id);
        // dd($data);
        return view('pages.admin.halaman-solusi.edit', compact('data'));
    }
    public function editSub($id)
    {
        $id = decrypt($id);
        $detail = HalamanSolusiDetail::with('translations')->findOrFail($id);

        // Pastikan sub-halaman sudah ada (dibuat saat pertama kali dibuka)
        $subpage = HalamanSolusiSubpage::with(['translations', 'items.translations'])->firstOrCreate(
            ['HalamanSolusiDetailId' => $detail->id],
            [
                'Judul'       => $detail->Judul,
                'Slug'        => $detail->Judul ? Str::slug($detail->Judul) : null,
                'IsPublished' => true,
            ]
        );

        return view('pages.admin.halaman-solusi.edit-sub', compact('detail', 'subpage'));
    }

    /**
     * Simpan/update konten sub-halaman solusi (dukung multi bahasa: Indonesia & Inggris).
     */
    public function updateSub(Request $request, $id)
    {
        $id = decrypt($id);
        $detail = HalamanSolusiDetail::findOrFail($id);
        $subpage = HalamanSolusiSubpage::firstOrNew(['HalamanSolusiDetailId' => $detail->id]);

        // Field teks subhalaman yang tersedia per bahasa (id & en)
        $translatableFields = [
            // Hero
            'Judul', 'SubJudul', 'Deskripsi', 'Konten',
            // Header Section 1 (Komponen)
            'Sec1SubJudul', 'Sec1Judul', 'Sec1Deskripsi',
            // Header Section 2 (Solusi)
            'Sec2SubJudul', 'Sec2Judul', 'Sec2Deskripsi',
            // Header Section 3 (Keamanan)
            'Sec3SubJudul', 'Sec3Judul', 'Sec3Deskripsi',
            // Header FAQ
            'FaqSubJudul', 'FaqJudul', 'FaqDeskripsi',
        ];
        $longTextFields = ['Deskripsi', 'Konten', 'Sec1Deskripsi', 'Sec2Deskripsi', 'Sec3Deskripsi', 'FaqDeskripsi'];

        $rules = [
            // Field bersama (tidak per bahasa)
            'Slug'         => 'nullable|string|max:255',
            'GambarHero'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'IsPublished'  => 'nullable|in:0,1',
            // Repeater item
            'komponen'      => 'nullable|array',
            'solusi_items'  => 'nullable|array',
            'security_items' => 'nullable|array',
            'faqs'          => 'nullable|array',
        ];
        foreach (['id', 'en'] as $locale) {
            foreach ($translatableFields as $field) {
                $rule = in_array($field, $longTextFields) ? 'nullable|string' : 'nullable|string|max:255';
                // Judul versi Indonesia wajib diisi
                if ($locale === 'id' && $field === 'Judul') {
                    $rule = 'required|string|max:255';
                }
                $rules["translations.$locale.$field"] = $rule;
            }
        }

        $request->validate($rules);

        $trans   = $request->input('translations', []);
        $idTrans = $trans['id'] ?? [];

        // ===== 1. Data Hero (kolom utama diisi versi Indonesia sebagai fallback) =====
        $subpage->Judul      = $idTrans['Judul'] ?? null;
        $subpage->SubJudul   = $idTrans['SubJudul'] ?? null;
        $subpage->Deskripsi  = $idTrans['Deskripsi'] ?? null;
        $subpage->Konten     = $idTrans['Konten'] ?? null;
        $subpage->Slug       = $request->Slug ?: Str::slug($subpage->Judul);
        $subpage->IsPublished = $request->has('IsPublished') ? (bool)$request->IsPublished : false;
        // ===== Section headers (Section 1, 2, 3 & FAQ) =====
        foreach ([
            'Sec1SubJudul', 'Sec1Judul', 'Sec1Deskripsi',
            'Sec2SubJudul', 'Sec2Judul', 'Sec2Deskripsi',
            'Sec3SubJudul', 'Sec3Judul', 'Sec3Deskripsi',
            'FaqSubJudul', 'FaqJudul', 'FaqDeskripsi',
        ] as $field) {
            $subpage->$field = $idTrans[$field] ?? null;
        }

        $subpage->UserUpdate = auth()->user()->name;
        if (!$subpage->exists) {
            $subpage->UserCreate = auth()->user()->name;
        }

        if ($request->hasFile('GambarHero')) {
            if ($subpage->GambarHero && Storage::disk('public')->exists($subpage->GambarHero)) {
                Storage::disk('public')->delete($subpage->GambarHero);
            }
            $file = $request->file('GambarHero');
            $subpage->GambarHero = $file->storeAs('halaman-solusi/subpage/hero', $file->hashName(), 'public');
        }
        $subpage->save();

        // ===== 1b. Terjemahan hero & header section (id & en) =====
        foreach (['id', 'en'] as $locale) {
            $values = [];
            foreach ($translatableFields as $field) {
                $values[$field] = $trans[$locale][$field] ?? null;
            }
            $subpage->translations()->updateOrCreate(['Locale' => $locale], $values);
        }

        // ===== 2. Item repeater per section =====
        $saveItems = function (array $rows, string $section, string $inputKey) use ($subpage, $request) {
            $keepIds = [];

            // Bersihkan daftar poin dari string kosong
            $cleanList = function ($list) {
                $list = array_map('trim', (array)($list ?? []));
                return array_values(array_filter($list, fn ($v) => $v !== '' && $v !== null));
            };

            foreach ($rows as $i => $row) {
                // Cari item lama berdasarkan Id hidden (pastikan milik subpage & section ini)
                $item = null;
                if (!empty($row['Id'])) {
                    $item = HalamanSolusiSubpageItem::where('HalamanSolusiSubpageId', $subpage->id)
                        ->where('Section', $section)
                        ->where('id', (int)$row['Id'])
                        ->first();
                }
                if (!$item) {
                    $item = new HalamanSolusiSubpageItem();
                    $item->HalamanSolusiSubpageId = $subpage->id;
                    $item->Section = $section;
                }

                // Nilai teks per bahasa (form FAQ memakai key Pertanyaan/Jawaban)
                $rowTrans = [];
                foreach (['id', 'en'] as $locale) {
                    $values = $row['translations'][$locale] ?? [];
                    if ($section === 'faq') {
                        $values = [
                            'Judul'     => $values['Pertanyaan'] ?? null,
                            'Deskripsi' => $values['Jawaban'] ?? null,
                        ];
                    }
                    $rowTrans[$locale] = $values;
                }

                // Kolom utama item diisi versi Indonesia sebagai fallback
                $item->Judul     = $rowTrans['id']['Judul'] ?? null;
                $item->SubJudul  = $rowTrans['id']['SubJudul'] ?? null;
                $item->Deskripsi = $rowTrans['id']['Deskripsi'] ?? null;

                if ($section === 'section1') {
                    // Tipe layout + poin-poin keunggulan (versi Indonesia di kolom utama)
                    $item->Tipe  = ($row['Tipe'] ?? 'besar') === 'horizontal' ? 'horizontal' : 'besar';
                    $item->Items = $cleanList($rowTrans['id']['Items'] ?? []);
                } else {
                    $item->Tipe  = null;
                    $item->Items = null;
                }

                // Upload gambar komponen (section1) / icon (section2 & 3)
                $fileInput = $section === 'section1'
                    ? "$inputKey.$i.Gambar"
                    : (in_array($section, ['section2', 'section3']) ? "$inputKey.$i.Icon" : null);

                if ($fileInput && $request->hasFile($fileInput)) {
                    $folder = $section === 'section1' ? 'halaman-solusi/subpage/komponen' : 'halaman-solusi/subpage/icon';
                    // Hapus file lama jika ada
                    foreach (['Gambar', 'Icon'] as $field) {
                        if ($item->$field && Storage::disk('public')->exists($item->$field)) {
                            Storage::disk('public')->delete($item->$field);
                        }
                    }
                    $file = $request->file($fileInput);
                    $stored = $file->storeAs($folder, $file->hashName(), 'public');
                    if ($section === 'section1') {
                        $item->Gambar = $stored;
                    } else {
                        $item->Icon = $stored;
                    }
                }

                $item->SortOrder = $i;
                $item->save();

                // Terjemahan item (id & en)
                foreach ($rowTrans as $locale => $values) {
                    $data = [
                        'Judul'     => $values['Judul'] ?? null,
                        'SubJudul'  => $values['SubJudul'] ?? null,
                        'Deskripsi' => $values['Deskripsi'] ?? null,
                    ];
                    if ($section === 'section1') {
                        $data['Items'] = $cleanList($values['Items'] ?? []);
                    }
                    $item->translations()->updateOrCreate(['Locale' => $locale], $data);
                }

                $keepIds[] = $item->id;
            }

            // Hapus item section ini yang sudah tidak ada di form (beserta filenya)
            $deleted = HalamanSolusiSubpageItem::where('HalamanSolusiSubpageId', $subpage->id)
                ->where('Section', $section)
                ->when(!empty($keepIds), fn ($q) => $q->whereNotIn('id', $keepIds))
                ->get();
            foreach ($deleted as $old) {
                foreach (['Gambar', 'Icon'] as $field) {
                    if ($old->$field && Storage::disk('public')->exists($old->$field)) {
                        Storage::disk('public')->delete($old->$field);
                    }
                }
                $old->translations()->delete();
                $old->delete();
            }
        };

        $saveItems($request->komponen ?? [], 'section1', 'komponen');
        $saveItems($request->solusi_items ?? [], 'section2', 'solusi_items');
        $saveItems($request->security_items ?? [], 'section3', 'security_items');
        $saveItems($request->faqs ?? [], 'faq', 'faqs');

        if ($detail->solusi) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($detail->solusi)
                ->withProperties(['attributes' => $subpage->toArray()])
                ->log('Memperbarui subhalaman solusi: ' . ($subpage->Judul ?? ($detail->Judul ?? '')));
        } else {
            activity()
                ->causedBy(auth()->user())
                ->log('Memperbarui subhalaman solusi: ' . ($subpage->Judul ?? ($detail->Judul ?? '')));
        }

        return redirect()
            ->route('halaman-solusi.detail.edit', encrypt($detail->id))
            ->with('success', 'Subhalaman solusi berhasil disimpan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'translations.id.Judul' => 'required|string|max:255',
            'translations.id.DeskripsiSingkat' => 'nullable|string',
            'translations.id.Konten' => 'required|string',
            'translations.id.SEOTitle' => 'nullable|string|max:70',
            'translations.id.SEODescription' => 'nullable|string|max:255',
            'translations.id.SEOKeywords' => 'nullable|string|max:255',
            'translations.en.Judul' => 'nullable|string|max:255',
            'translations.en.DeskripsiSingkat' => 'nullable|string',
            'translations.en.Konten' => 'nullable|string',
            'translations.en.SEOTitle' => 'nullable|string|max:70',
            'translations.en.SEODescription' => 'nullable|string|max:255',
            'translations.en.SEOKeywords' => 'nullable|string|max:255',
            'Slug' => 'nullable|string|max:255',
            'IsPublished' => 'required|in:0,1',
            'Thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'details' => 'required|array|min:1',
            'details.*.gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'details.*.translations.id.Judul' => 'required|string|max:255',
            'details.*.translations.id.Keterangan' => 'nullable|string',
            'details.*.translations.en.Judul' => 'nullable|string|max:255',
            'details.*.translations.en.Keterangan' => 'nullable|string',
            'faqs_main' => 'nullable|array',
            'faqs_main.*.translations.id.Pertanyaan' => 'nullable|string',
            'faqs_main.*.translations.id.Jawaban' => 'nullable|string',
            'faqs_main.*.translations.en.Pertanyaan' => 'nullable|string',
            'faqs_main.*.translations.en.Jawaban' => 'nullable|string',
        ]);

        $solusi = HalamanSolusi::findOrFail($id);

        $buildFaqItems = function (array $faqsMain, string $locale) {
            return collect($faqsMain)->map(fn ($row) => [
                'q' => $row['translations'][$locale]['Pertanyaan'] ?? null,
                'a' => $row['translations'][$locale]['Jawaban'] ?? null,
            ])->filter(fn ($item) => !empty($item['q']) || !empty($item['a']))->values()->all();
        };

        // Update Data Utama
        $solusi->Judul = $validated['translations']['id']['Judul'];
        $solusi->DeskripsiSingkat = $validated['translations']['id']['DeskripsiSingkat'] ?? null;
        $solusi->Konten = $validated['translations']['id']['Konten'];
        $solusi->FaqItems = !empty($request->faqs_main) ? $buildFaqItems($request->faqs_main, 'id') : null;
        $solusi->SEOTitle = $validated['translations']['id']['SEOTitle'] ?? null;
        $solusi->SEODescription = $validated['translations']['id']['SEODescription'] ?? null;
        $solusi->SEOKeywords = $validated['translations']['id']['SEOKeywords'] ?? null;

        // Auto-generate slug unik saat update (kecuali milik data ini sendiri)
        $baseSlug = Str::slug($request->Slug ?: $solusi->Judul);
        $slug = $baseSlug;
        $counter = 1;
        while (HalamanSolusi::where('Slug', $slug)->where('id', '!=', $solusi->id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $solusi->Slug = $slug;

        $solusi->IsPublished = $request->IsPublished;
        $solusi->UserUpdate = auth()->user()->name;

        if ($request->hasFile('Thumbnail')) {
            if ($solusi->Thumbnail && Storage::disk('public')->exists($solusi->Thumbnail)) {
                Storage::disk('public')->delete($solusi->Thumbnail);
            }
            $solusi->Thumbnail = $request->file('Thumbnail')->storeAs('halaman-solusi/thumbnail', $request->file('Thumbnail')->hashName(), 'public');
        }
        $solusi->save();

        // Update Terjemahan Utama
        foreach (['id', 'en'] as $locale) {
            $solusi->translations()->updateOrCreate(
                ['Locale' => $locale],
                [
                    'Judul' => $validated['translations'][$locale]['Judul'] ?? null,
                    'DeskripsiSingkat' => $validated['translations'][$locale]['DeskripsiSingkat'] ?? null,
                    'Konten' => $validated['translations'][$locale]['Konten'] ?? null,
                    'FaqItems' => !empty($request->faqs_main) ? $buildFaqItems($request->faqs_main, $locale) : null,
                    'SEOTitle' => $validated['translations'][$locale]['SEOTitle'] ?? null,
                    'SEODescription' => $validated['translations'][$locale]['SEODescription'] ?? null,
                    'SEOKeywords' => $validated['translations'][$locale]['SEOKeywords'] ?? null,
                ]
            );
        }

        // Update atau sinkronkan detail & terjemahan
        if (is_array($request->details)) {
            $keptDetailIds = [];

            foreach ($request->details as $i => $det) {
                $detailId = !empty($det['id']) ? (int) $det['id'] : null;
                $detail = $detailId ? $solusi->details()->where('id', $detailId)->first() : null;

                if (!$detail) {
                    $detail = new HalamanSolusiDetail();
                    $detail->HalamanSolusiId = $solusi->id;
                }

                if ($request->hasFile("details.$i.gambar")) {
                    if ($detail->Gambar && Storage::disk('public')->exists($detail->Gambar)) {
                        Storage::disk('public')->delete($detail->Gambar);
                    }
                    $file = $request->file("details.$i.gambar");
                    $detail->Gambar = $file->storeAs('halaman-solusi/detail', $file->hashName(), 'public');
                }

                // Fallback Judul & Keterangan di model utama
                $detail->Judul = $det['translations']['id']['Judul'] ?? null;
                $detail->Keterangan = $det['translations']['id']['Keterangan'] ?? null;
                $detail->save();

                foreach (['id', 'en'] as $locale) {
                    if (!empty($det['translations'][$locale]['Judul'])) {
                        $detail->translations()->updateOrCreate(
                            ['Locale' => $locale],
                            [
                                'Judul' => $det['translations'][$locale]['Judul'] ?? null,
                                'Keterangan' => $det['translations'][$locale]['Keterangan'] ?? null,
                            ]
                        );
                    }
                }

                $keptDetailIds[] = $detail->id;
            }

            // Hapus detail yang sudah dihapus oleh user pada form
            $removedDetails = $solusi->details()->whereNotIn('id', $keptDetailIds)->get();
            foreach ($removedDetails as $rem) {
                if ($rem->Gambar && Storage::disk('public')->exists($rem->Gambar)) {
                    Storage::disk('public')->delete($rem->Gambar);
                }
                $rem->translations()->delete();
                if ($rem->subpage) {
                    $rem->subpage->items()->delete();
                    $rem->subpage->translations()->delete();
                    $rem->subpage->delete();
                }
                $rem->delete();
            }
        }

        return redirect()->route('halaman-solusi.index')->with('success', 'Solusi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        try {
            $halamanSolusi = HalamanSolusi::findOrFail($id);
            HalamanSolusiDetail::where('HalamanSolusiId', $halamanSolusi->id)->delete();
            // Hapus data utama
            $halamanSolusi->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Halaman Solusi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal menghapus data. Silakan coba lagi.'
            ], 500);
        }
    }
}
