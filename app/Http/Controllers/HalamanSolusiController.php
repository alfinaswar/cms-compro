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
        ]);

        // 1. Simpan Data Utama (fallback ke Bahasa Indonesia)
        $solusi = new HalamanSolusi();
        $solusi->Judul = $validated['translations']['id']['Judul'];
        $solusi->DeskripsiSingkat = $validated['translations']['id']['DeskripsiSingkat'] ?? null;
        $solusi->Konten = $validated['translations']['id']['Konten'];
        $solusi->SEOTitle = $validated['translations']['id']['SEOTitle'] ?? null;
        $solusi->SEODescription = $validated['translations']['id']['SEODescription'] ?? null;
        $solusi->SEOKeywords = $validated['translations']['id']['SEOKeywords'] ?? null;
        $solusi->Slug = $request->Slug ?: Str::slug($solusi->Judul);
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
        $halamanSolusi = HalamanSolusi::with(['details.translations', 'details.subpage', 'translations'])
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
        $subpage = HalamanSolusiSubpage::with(['items', 'detail.translations'])
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
        $subpage = HalamanSolusiSubpage::with('items')->firstOrCreate(
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
     * Simpan/update konten sub-halaman solusi.
     */
    public function updateSub(Request $request, $id)
    {
        $id = decrypt($id);
        $detail = HalamanSolusiDetail::findOrFail($id);
        $subpage = HalamanSolusiSubpage::firstOrNew(['HalamanSolusiDetailId' => $detail->id]);

        $request->validate([
            // Hero
            'Judul'        => 'required|string|max:255',
            'SubJudul'     => 'nullable|string|max:255',
            'Deskripsi'    => 'nullable|string',
            'Konten'       => 'nullable|string',
            'Slug'         => 'nullable|string|max:255',
            'GambarHero'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'IsPublished'  => 'nullable|in:0,1',
            // Header Section 1 (Komponen)
            'Sec1SubJudul' => 'nullable|string|max:255',
            'Sec1Judul'    => 'nullable|string|max:255',
            'Sec1Deskripsi' => 'nullable|string',
            // Header Section 2 (Solusi)
            'Sec2SubJudul' => 'nullable|string|max:255',
            'Sec2Judul'    => 'nullable|string|max:255',
            'Sec2Deskripsi' => 'nullable|string',
            // Header Section 3 (Keamanan)
            'Sec3SubJudul' => 'nullable|string|max:255',
            'Sec3Judul'    => 'nullable|string|max:255',
            'Sec3Deskripsi' => 'nullable|string',
            // Header FAQ
            'FaqSubJudul'  => 'nullable|string|max:255',
            'FaqJudul'     => 'nullable|string|max:255',
            'FaqDeskripsi' => 'nullable|string',
            // Repeater item
            'komponen'      => 'nullable|array',
            'solusi_items'  => 'nullable|array',
            'security_items' => 'nullable|array',
            'faqs'          => 'nullable|array',
        ]);

        // ===== 1. Data Hero =====
        $subpage->Judul      = $request->Judul;
        $subpage->SubJudul   = $request->SubJudul;
        $subpage->Deskripsi  = $request->Deskripsi;
        $subpage->Konten     = $request->Konten;
        $subpage->Slug       = $request->Slug ?: Str::slug($subpage->Judul);
        $subpage->IsPublished = $request->has('IsPublished') ? (bool)$request->IsPublished : false;
        // ===== Section headers (Section 1, 2, 3 & FAQ) =====
        foreach ([
            'Sec1SubJudul', 'Sec1Judul', 'Sec1Deskripsi',
            'Sec2SubJudul', 'Sec2Judul', 'Sec2Deskripsi',
            'Sec3SubJudul', 'Sec3Judul', 'Sec3Deskripsi',
            'FaqSubJudul', 'FaqJudul', 'FaqDeskripsi',
        ] as $field) {
            $subpage->$field = $request->$field;
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

        // ===== 2. Item repeater per section =====
        $saveItems = function (array $rows, string $section) use ($subpage, $request) {
            $keepIds = [];

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

                if ($section === 'faq') {
                    $item->Judul     = $row['Pertanyaan'] ?? null;
                    $item->Deskripsi = $row['Jawaban'] ?? null;
                } else {
                    $item->Judul     = $row['Judul'] ?? null;
                    $item->SubJudul  = $row['SubJudul'] ?? null;
                    $item->Deskripsi = $row['Deskripsi'] ?? null;
                }

                if ($section === 'section1') {
                    // Tipe layout + poin-poin keunggulan
                    $item->Tipe  = ($row['Tipe'] ?? 'besar') === 'horizontal' ? 'horizontal' : 'besar';
                    $items       = array_map('trim', (array)($row['Items'] ?? []));
                    $item->Items = array_values(array_filter($items, fn ($v) => $v !== '' && $v !== null));
                } else {
                    $item->Tipe  = null;
                    $item->Items = null;
                }

                // Upload gambar komponen (section1) / icon (section2 & 3)
                $fileInput = $section === 'section1'
                    ? "komponen.$i.Gambar"
                    : ($section === 'section2' ? "solusi_items.$i.Icon" : ($section === 'section3' ? "security_items.$i.Icon" : null));

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
                $old->delete();
            }
        };

        $saveItems($request->komponen ?? [], 'section1');
        $saveItems($request->solusi_items ?? [], 'section2');
        $saveItems($request->security_items ?? [], 'section3');
        $saveItems($request->faqs ?? [], 'faq');

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
        ]);

        $solusi = HalamanSolusi::findOrFail($id);

        // Update Data Utama
        $solusi->Judul = $validated['translations']['id']['Judul'];
        $solusi->DeskripsiSingkat = $validated['translations']['id']['DeskripsiSingkat'] ?? null;
        $solusi->Konten = $validated['translations']['id']['Konten'];
        $solusi->SEOTitle = $validated['translations']['id']['SEOTitle'] ?? null;
        $solusi->SEODescription = $validated['translations']['id']['SEODescription'] ?? null;
        $solusi->SEOKeywords = $validated['translations']['id']['SEOKeywords'] ?? null;
        $solusi->Slug = $request->Slug ?: Str::slug($solusi->Judul);
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
                    'SEOTitle' => $validated['translations'][$locale]['SEOTitle'] ?? null,
                    'SEODescription' => $validated['translations'][$locale]['SEODescription'] ?? null,
                    'SEOKeywords' => $validated['translations'][$locale]['SEOKeywords'] ?? null,
                ]
            );
        }

        // Hapus detail lama & file-nya (untuk menghindari data sampah/orphaned files)
        $oldDetails = $solusi->details;
        foreach ($oldDetails as $oldDetail) {
            if ($oldDetail->Gambar && \Storage::disk('public')->exists($oldDetail->Gambar)) {
                \Storage::disk('public')->delete($oldDetail->Gambar);
            }
            $oldDetail->delete();  // Cascade delete akan otomatis menghapus translations-nya
        }

        // Buat ulang detail baru
        if (is_array($request->details)) {
            foreach ($request->details as $i => $det) {
                $detail = new HalamanSolusidetail();
                $detail->HalamanSolusiId = $solusi->id;

                if ($request->hasFile("details.$i.gambar")) {
                    $file = $request->file("details.$i.gambar");
                    $detail->Gambar = $file->storeAs('halaman-solusi/detail', $file->hashName(), 'public');
                }
                $detail->save();

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
