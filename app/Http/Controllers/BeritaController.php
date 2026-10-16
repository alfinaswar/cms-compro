<?php
namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:berita.view')->only(['index', 'show']);
        $this->middleware('permission:berita.create')->only(['create', 'store', 'uploadImage', 'storeKategoriAjax']);
        $this->middleware('permission:berita.edit')->only(['edit', 'update']);
        $this->middleware('permission:berita.delete')->only(['destroy']);
    }

    /**
     * Display a listing of the resource (DataTables Server-side).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Berita::with([
                'translations' => function ($q) {
                    $q->where('Locale', 'id');
                }
            ])->latest();
            if ($request->has('kategori') && !empty($request->kategori)) {
                $query->where(function ($q) use ($request) {
                    $q->where('Kategori', $request->kategori)
                        ->orWhereHas('kategori', function ($kq) use ($request) {
                            $kq->where('NamaKategori', $request->kategori);
                        });
                });
            }
            if ($request->has('status') && !empty($request->status)) {
                if (in_array(strtolower($request->status), ['draf', 'draft'])) {
                    $query->whereIn('Status', ['Draf', 'Draft']);
                } else {
                    $query->where('Status', $request->status);
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('Thumbnail', function ($row) {
                    if ($row->PathThumbnail) {
                        return '<img src="' . Storage::url($row->PathThumbnail) . '" class="rounded shadow-sm" style="width:70px; height:50px; object-fit:cover;">';
                    }
                    return '<div class="bg-light text-muted d-flex align-items-center justify-content-center rounded" style="width:70px; height:50px; font-size: 11px;">No Image</div>';
                })
                ->addColumn('Judul', function ($row) {
                    $trans = $row->translations->first();
                    $judul = $trans ? $trans->Judul : ($row->Judul ?? 'Tanpa Judul');
                    $penulis = $row->Penulis ?? 'Redaksi Humas Jasuindo';

                    return '<div class="font-weight-bold text-dark mb-1" style="font-size:14px; line-height: 1.3;">' . e($judul) . '</div>'
                        . '<small class="text-muted" style="font-size:12px;">Oleh: ' . e($penulis) . '</small>';
                })
                ->addColumn('TanggalPublikasi', function ($row) {
                    $tanggal = $row->TanggalPublikasi ? \Carbon\Carbon::parse($row->TanggalPublikasi) : $row->created_at;
                    if (!$tanggal)
                        return '-';
                    return '<div class="font-weight-bold text-dark" style="font-size:13px;">' . $tanggal->translatedFormat('d M Y') . '</div>'
                        . '<small class="text-muted" style="font-size:11px;">' . ($row->created_at ? $row->created_at->format('H:i') . ' WIB' : '') . '</small>';
                })
                ->addColumn('StatusBadge', function ($row) {
                    if ($row->Status === 'Draf' || $row->Status === 'Draft') {
                        return '<span class="badge badge-pill badge-warning text-dark px-3 py-1" style="background-color: #FFF3CD; border: 1px solid #FFEEBA;"><i class="fa fa-circle mr-1 text-warning" style="font-size:8px;"></i> Draf</span>';
                    } elseif ($row->Status === 'Diterbitkan' || $row->Status === 'Terbit') {
                        return '<span class="badge badge-pill badge-success px-3 py-1" style="background-color: #D4EDDA; color: #155724; border: 1px solid #C3E6CB;"><i class="fa fa-circle mr-1 text-success" style="font-size:8px;"></i> Terbit</span>';
                    }
                    return '<span class="badge badge-pill badge-secondary px-3 py-1">' . e($row->Status) . '</span>';
                })
                ->addColumn('Tags', function ($row) {
                    if (!$row->Tags)
                        return '-';
                    $tags = array_map('trim', explode(',', $row->Tags));
                    $html = '';
                    foreach ($tags as $t) {
                        if ($t !== '') {
                            $html .= '<span class="badge badge-light border text-secondary mr-1 mb-1">' . e($t) . '</span>';
                        }
                    }
                    return $html ?: '-';
                })
                ->addColumn('action', function ($row) {
                    // Tombol aksi clean tanpa background tebal (flat icon look)
                    $btn = '<div class="d-flex align-items-center justify-content-start" style="gap: 12px;">';
                    if (auth()->user()->can('berita.view')) {
                        $btn .= '<a href="' . route('frontend.detail', $row->Slug) . '" target="_blank" class="text-secondary" title="Lihat"><i class="far fa-eye" style="font-size:16px;"></i></a>';
                    }
                    if (auth()->user()->can('berita.edit')) {
                        $btn .= '<a href="' . route('berita.edit', $row->Slug) . '" class="text-secondary" title="Edit"><i class="far fa-edit" style="font-size:16px;"></i></a>';
                    }
                    if (auth()->user()->can('berita.delete')) {
                        $btn .= '<a href="javascript:void(0)" class="text-secondary btn-delete" data-id="' . $row->id . '" title="Hapus"><i class="far fa-trash-alt" style="font-size:16px;"></i></a>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('Kategori', function ($row) {
                    if ($row->kategori) {
                        return '<span class="badge badge-info px-2 py-1">' . e($row->kategori->NamaKategori) . '</span>';
                    }
                    return '<span class="badge badge-info px-2 py-1">' . e($row->Kategori ?? '-') . '</span>';
                })

                ->rawColumns(['Thumbnail', 'Judul', 'TanggalPublikasi', 'StatusBadge', 'action', 'Kategori', 'Tags'])
                ->make(true);
        }
        $kategori = KategoriBerita::get();
        return view('pages.admin.berita.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriBerita::orderBy('NamaKategori')->get();
        return view('pages.admin.berita.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'translations.id.Judul' => 'required|string|max:255',
            'Kategori' => 'required|string|max:100',
            'Tags' => 'nullable|string',
            'PathThumbnail' => 'required|image|mimes:webp|max:307',

            'Status' => 'required|in:Draf,Diterbitkan,Arsip',
            'TanggalPublikasi' => 'nullable|date',
            'Penulis' => 'nullable|string|max:100',
            'Konten' => 'required|string',
            'translations.id.Ringkasan' => 'nullable|string',
            'translations.id.SEOTitle' => 'nullable|string|max:70',
            'translations.id.SEODescription' => 'nullable|string|max:160',
            'translations.id.SEOKeywords' => 'nullable|string|max:255',
            'translations.en.Judul' => 'nullable|string|max:255',
            'translations.en.Ringkasan' => 'nullable|string',
            'translations.en.Konten' => 'nullable|string',

            'translations.en.SEOTitle' => 'nullable|string|max:70',
            'translations.en.SEODescription' => 'nullable|string|max:160',
            'translations.en.SEOKeywords' => 'nullable|string|max:255',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('PathThumbnail')) {
            $validated['PathThumbnail'] = $request->file('PathThumbnail')->store('berita/thumbnail', 'public');
        }

        // Tags
        $tags = $validated['Tags'];
        if (is_array($tags)) {
            $tags = implode(', ', $tags);
        }
        $kontenId = $validated['Konten'];
        $ringkasanDefault = null;
        if ($kontenId) {
            $ringkasanDefault = trim(preg_split('/\R{2,}|\n{2,}/', strip_tags($kontenId))[0] ?? '');
            if (empty($ringkasanDefault)) {
                $ringkasanDefault = Str::limit(strip_tags($kontenId), 200);
            }
        }

        $seoTitleDefault = $validated['translations']['id']['Judul'] ?? '';
        $seoDescriptionDefault = $ringkasanDefault;
        $slugBase = Str::slug($validated['translations']['id']['Judul'] ?? $validated['Judul'] ?? 'berita');
        $slug = $slugBase;
        $count = 1;
        while (Berita::where('Slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $count;
            $count++;
        }

        $mainData = [
            'Judul' => $validated['translations']['id']['Judul'] ?? $validated['Judul'] ?? null,
            'Kategori' => $validated['Kategori'],
            'Tags' => $tags,
            'PathThumbnail' => $validated['PathThumbnail'],
            'Status' => $validated['Status'],
            'TanggalPublikasi' => $validated['TanggalPublikasi'],
            'Penulis' => $validated['Penulis'] ?? (auth()->user() ? auth()->user()->name : null),
            'UserCreate' => (auth()->user() ? auth()->user()->name : null),
            'Slug' => $slug,
        ];

        $berita = Berita::create($mainData);
        $translationsData = $request->input('translations', []);
        $translationsData['id']['Konten'] = $validated['Konten'];

        foreach (['id', 'en'] as $locale) {
            if (
                isset($translationsData[$locale]) &&
                (!empty($translationsData[$locale]['Judul']) || !empty($translationsData[$locale]['Konten']))
            ) {
                $data = $translationsData[$locale];
                if ($locale === 'id') {
                    $data['Ringkasan'] = !empty($data['Ringkasan']) ? $data['Ringkasan'] : $ringkasanDefault;
                }
                $data['SEOTitle'] = !empty($data['SEOTitle'])
                    ? $data['SEOTitle'] : ($locale === 'id' ? $seoTitleDefault : ($data['Judul'] ?? null));

                $data['SEODescription'] = !empty($data['SEODescription'])
                    ? $data['SEODescription'] : ($locale === 'id' ? $seoDescriptionDefault : (isset($data['Ringkasan']) ? $data['Ringkasan'] : null));

                if (empty($data['SEOKeywords'])) {
                    if (!empty($data['Judul'])) {
                        $words = array_unique(array_slice(
                            preg_split('/[\s,\.]+/', strtolower(strip_tags($data['Judul']))),
                            0,
                            5
                        ));
                        $data['SEOKeywords'] = implode(', ', $words);
                    } else {
                        $data['SEOKeywords'] = null;
                    }
                }

                $berita->translations()->create([
                    'Locale' => $locale,
                    'Judul' => $data['Judul'] ?? null,
                    'Ringkasan' => $data['Ringkasan'] ?? null,
                    'Konten' => $data['Konten'] ?? null,
                    'SEOTitle' => $data['SEOTitle'] ?? null,
                    'SEODescription' => $data['SEODescription'] ?? null,
                    'SEOKeywords' => $data['SEOKeywords'] ?? null,
                ]);
            }
        }

        $judulLog = $translationsData['id']['Judul'] ?? 'Berita Baru';
        activity()
            ->causedBy(auth()->user())
            ->performedOn($berita)
            ->withProperties(['attributes' => $mainData, 'translations' => $translationsData])
            ->log('Menambahkan berita baru: ' . $judulLog);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $berita = Berita::where('Slug', $id)->orWhere('id', $id)->firstOrFail();
        $kategoris = KategoriBerita::orderBy('NamaKategori')->get();
        return view('pages.admin.berita.edit', compact('berita', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $validated = $request->validate([
            'Kategori' => 'required|string|max:100',
            'Tags' => 'nullable|string',
            'PathThumbnail' => 'nullable|image|mimes:webp|max:307',
            'Status' => 'required|in:Draf,Diterbitkan,Arsip',
            'TanggalPublikasi' => 'nullable|date',
            'Penulis' => 'nullable|string|max:100',
            'Judul' => 'required|string|max:255',
            'Ringkasan' => 'nullable|string',
            'Konten' => 'required|string',
            'SEOTitle' => 'nullable|string|max:70',
            'SEODescription' => 'nullable|string|max:160',
            'SEOKeywords' => 'nullable|string|max:255',
            // Inggris (Array names)
            'translations.en.Judul' => 'nullable|string|max:255',
            'translations.en.Ringkasan' => 'nullable|string',
            'translations.en.Konten' => 'nullable|string',
            'translations.en.SEOTitle' => 'nullable|string|max:70',
            'translations.en.SEODescription' => 'nullable|string|max:160',
            'translations.en.SEOKeywords' => 'nullable|string|max:255',
        ]);

        // Handle Thumbnail Update
        if ($request->hasFile('PathThumbnail')) {
            if ($berita->PathThumbnail && \Storage::disk('public')->exists($berita->PathThumbnail)) {
                \Storage::disk('public')->delete($berita->PathThumbnail);
            }
            $validated['PathThumbnail'] = $request->file('PathThumbnail')->store('berita/thumbnail', 'public');
        }

        // Tags selalu string - jika array, konversi ke string
        $tags = $validated['Tags'];
        if (is_array($tags)) {
            $tags = implode(', ', $tags);
        }

        // RINGKASAN: Jika kosong, ambil paragraf pertama dari konten
        $ringkasan = $validated['Ringkasan'] ?? null;
        if (empty($ringkasan) && !empty($validated['Konten'])) {
            // Ambil 1 paragraf awal dari konten (setelah bersihkan tag HTML)
            $kontenText = trim(strip_tags($validated['Konten']));
            $paragraphs = preg_split('/\r\n|\r|\n/', $kontenText);
            $ringkasan = trim($paragraphs[0]);
            if (empty($ringkasan)) {
                // Jika string kosong, ambil 200 karakter awal
                $ringkasan = mb_substr($kontenText, 0, 200) . (mb_strlen($kontenText) > 200 ? "..." : "");
            }
        }

        // SEO TITLE: Jika kosong, gunakan judul
        $seoTitle = $validated['SEOTitle'] ?? null;
        if (empty($seoTitle)) {
            $seoTitle = $validated['Judul'];
        }

        // SEO DESCRIPTION: Jika kosong, ambil dari ringkasan (atau judul)
        $seoDescription = $validated['SEODescription'] ?? null;
        if (empty($seoDescription)) {
            $seoDescription = !empty($ringkasan) ? $ringkasan : $validated['Judul'];
            $seoDescription = mb_substr(strip_tags($seoDescription), 0, 160);
        }

        // SEO KEYWORDS: Jika kosong, buat dari judul (5 kata unik pertama)
        $seoKeywords = $validated['SEOKeywords'] ?? null;
        if (empty($seoKeywords)) {
            $words = array_unique(array_slice(
                preg_split('/[\s,\.]+/', strtolower(strip_tags($validated['Judul']))),
                0,
                5
            ));
            $seoKeywords = implode(', ', array_filter($words));
        }

        // Data Utama (Non-translatable)
        $mainData = [
            'Judul' => $validated['translations']['id']['Judul'] ?? $validated['Judul'] ?? $berita->Judul,
            'Kategori' => $validated['Kategori'],
            'Tags' => $tags,
            'Status' => $validated['Status'],
            'TanggalPublikasi' => $validated['TanggalPublikasi'],
            'Penulis' => $validated['Penulis'],
            'UserUpdate' => auth()->user() ? auth()->user()->name : null,
            // Slug tidak diubah pada update
        ];

        if (isset($validated['PathThumbnail'])) {
            $mainData['PathThumbnail'] = $validated['PathThumbnail'];
        }

        $berita->update($mainData);

        // Siapkan Data Translasi
        $translationsData = $request->input('translations', []);

        // Field flat Indonesia -- pastikan field mengisi default data jika kosong
        $translationsData['id'] = [
            'Judul' => $validated['Judul'],
            'Ringkasan' => $ringkasan,
            'Konten' => $validated['Konten'],
            'SEOTitle' => $seoTitle,
            'SEODescription' => $seoDescription,
            'SEOKeywords' => $seoKeywords,
        ];

        // Update/Create ke Tabel Translasi
        foreach ($translationsData as $locale => $trans) {
            // Untuk locale selain 'id', ambil langkah fallback ringkasan, seo title dll jika kosong
            $judul = $trans['Judul'] ?? null;
            $konten = $trans['Konten'] ?? null;
            $ringkasanT = $trans['Ringkasan'] ?? null;
            $seoTitleT = $trans['SEOTitle'] ?? null;
            $seoDescT = $trans['SEODescription'] ?? null;
            $seoKeywordsT = $trans['SEOKeywords'] ?? null;

            if (empty($ringkasanT) && !empty($konten)) {
                $kontenText = trim(strip_tags($konten));
                $paragraphs = preg_split('/\r\n|\r|\n/', $kontenText);
                $ringkasanT = trim($paragraphs[0]);
                if (empty($ringkasanT)) {
                    $ringkasanT = mb_substr($kontenText, 0, 200) . (mb_strlen($kontenText) > 200 ? "..." : "");
                }
            }

            if (empty($seoTitleT) && !empty($judul)) {
                $seoTitleT = $judul;
            }

            if (empty($seoDescT)) {
                $seoDescT = !empty($ringkasanT) ? $ringkasanT : ($judul ?? '');
                $seoDescT = mb_substr(strip_tags($seoDescT), 0, 160);
            }

            if (empty($seoKeywordsT) && !empty($judul)) {
                $words = array_unique(array_slice(
                    preg_split('/[\s,\.]+/', strtolower(strip_tags($judul))),
                    0,
                    5
                ));
                $seoKeywordsT = implode(', ', array_filter($words));
            }

            if (!empty($judul) || !empty($konten)) {
                $berita->translations()->updateOrCreate(
                    ['Locale' => $locale],
                    [
                        'Judul' => $judul ?? null,
                        'Ringkasan' => $ringkasanT,
                        'Konten' => $konten ?? null,
                        'SEOTitle' => $seoTitleT,
                        'SEODescription' => $seoDescT,
                        'SEOKeywords' => $seoKeywordsT,
                    ]
                );
            }
        }

        activity()
            ->causedBy(auth()->user())
            ->performedOn($berita)
            ->withProperties(['attributes' => $mainData, 'translations' => $translationsData])
            ->log('Mengupdate berita: ' . $validated['Judul']);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Display the specified resource (Public View).
     */
    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('berita.show', compact('berita'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berita = Berita::find($id);
        if (!$berita) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus file fisik
        if ($berita->PathThumbnail && Storage::disk('public')->exists($berita->PathThumbnail)) {
            Storage::disk('public')->delete($berita->PathThumbnail);
        }

        $berita->update(['UserDelete' => auth()->user()->name]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($berita)
            ->withProperties(['old' => $berita->toArray()])
            ->log('Menghapus berita: ' . ($berita->translations()->where('Locale', 'id')->value('Judul') ?? $berita->id));

        $berita->delete();  // Soft delete

        return response()->json(['status' => 200, 'message' => 'Berita berhasil dihapus']);
    }

    /**
     * Upload image for Summernote (AJAX).
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('berita/content', 'public');
            return response()->json(['url' => Storage::url($path)]);
        }

        return response()->json(['error' => 'Upload gagal'], 400);
    }

    public function storeKategoriAjax(Request $request)
    {
        // dd($request->all());

        $kategori = KategoriBerita::create([
            'NamaKategori' => $request->NamaKategori,
        ]);

        return response()->json([
            'status' => 200,
            'message' => "Kategori \"{$kategori->NamaKategori}\" berhasil ditambahkan.",
            'data' => $kategori,
        ]);
    }

    public function news(Request $request)
    {
        // dd($request->all());
        $kategori = KategoriBerita::where('NamaKategori', $request->kategori)->first();
        $locale = app()->getLocale();
        $query = Berita::where('Status', 'Diterbitkan');
        $query->with([
            'translations' => function ($q) use ($locale) {
                $q->where('Locale', $locale);
            }
        ]);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('translations', function ($q) use ($search, $locale) {
                $q
                    ->where('Locale', $locale)
                    ->where(function ($subQ) use ($search) {
                        $subQ
                            ->where('Judul', 'like', '%' . $search . '%')
                            ->orWhere('Ringkasan', 'like', '%' . $search . '%');
                    });
            });
        }
        if ($request->filled('kategori')) {
            $query->where('Kategori', $kategori->id ?? $request->kategori);
        }
        if ($request->filled('tag')) {
            $query->where('Tags', 'like', '%' . $request->tag . '%');
        }
        $news = $query->latest('TanggalPublikasi')->paginate(10);
        $recentNews = Berita::where('Status', 'Diterbitkan')
            ->with([
                'translations' => function ($q) use ($locale) {
                    $q->where('Locale', $locale);
                }
            ])
            ->latest('TanggalPublikasi')
            ->take(3)
            ->get();
        $categories = KategoriBerita::pluck('NamaKategori');

        return view('frontend.news', compact('news', 'recentNews', 'categories', 'locale'));
    }

    public function newsDetail($locale, $slug)
    {
        $locale = app()->getLocale();

        // 1. Main News: Eager load all translations so fallback works
        $news = Berita::with('translations')->where('Slug', $slug)->firstOrFail();

        // 2. Recent News (Sidebar): Eager load translations
        $recentNews = Berita::with('translations')
            ->where('id', '!=', $news->id)
            ->where('Status', 'Diterbitkan')
            ->latest('TanggalPublikasi')
            ->take(3)
            ->get();

        // 3. Categories from master KategoriBerita
        $categories = KategoriBerita::pluck('NamaKategori');

        // 4. Prev/Next Posts: Eager load translations
        $prevPost = Berita::with('translations')
            ->where('TanggalPublikasi', '<', $news->TanggalPublikasi)
            ->where('Status', 'Diterbitkan')
            ->latest('TanggalPublikasi')
            ->first();

        $nextPost = Berita::with('translations')
            ->where('TanggalPublikasi', '>', $news->TanggalPublikasi)
            ->where('Status', 'Diterbitkan')
            ->oldest('TanggalPublikasi')
            ->first();

        // 5. Related Posts: Eager load translations
        $relatedPosts = Berita::with('translations')
            ->where('Kategori', $news->Kategori)
            ->where('id', '!=', $news->id)
            ->where('Status', 'Diterbitkan')
            ->latest('TanggalPublikasi')
            ->take(3)
            ->get();

        return view('frontend.news-detail', compact(
            'news',
            'recentNews',
            'categories',
            'prevPost',
            'nextPost',
            'relatedPosts',
            'locale'  // Kirim locale ke view
        ));
    }
    public function searchArticles(Request $request)
    {
        $q = trim($request->get('q', ''));
        $locale = app()->getLocale();
        if (strlen($q) < 2) {
            return response()->json(['results' => [], 'query' => $q]);
        }
        $articles = Berita::where('Status', 'Diterbitkan')
            ->where(function ($query) use ($q) {
                $query->where('Judul', 'LIKE', "%{$q}%")
                    ->orWhere('JudulEn', 'LIKE', "%{$q}%")
                    ->orWhere('Ringkasan', 'LIKE', "%{$q}%")
                    ->orWhere('RingkasanEn', 'LIKE', "%{$q}%")
                    ->orWhere('Tags', 'LIKE', "%{$q}%");
            })
            ->with([
                'translations' => function ($t) use ($locale) {
                    $t->where('Locale', $locale);
                }
            ])
            ->latest('TanggalPublikasi')
            ->take(6)
            ->get()
            ->map(function ($article) use ($locale) {
                $trans = $article->translations->firstWhere('Locale', $locale);
                return [
                    'id' => $article->id,
                    'judul' => $trans->Judul ?? $article->Judul,
                    'ringkasan' => $trans->Ringkasan ?? $article->Ringkasan,
                    'slug' => $article->Slug,
                    'kategori' => $article->Kategori,
                    'tanggal' => $article->TanggalPublikasi
                        ? \Carbon\Carbon::parse($article->TanggalPublikasi)->isoFormat('D MMM Y')
                        : '-',
                    'thumbnail' => $article->PathThumbnail
                        ? asset('storage/' . $article->PathThumbnail)
                        : null,
                    'url' => route('frontend.detail', ['slug' => $article->Slug]),
                ];
            });

        return response()->json([
            'results' => $articles,
            'query' => $q,
            'count' => $articles->count(),
        ]);
    }
}
