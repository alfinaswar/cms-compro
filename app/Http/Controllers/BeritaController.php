<?php
namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Spatie\Activitylog\Models\Activity;

class BeritaController extends Controller
{
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

            // Filter Kategori (opsional)
            if ($request->has('kategori') && !empty($request->kategori)) {
                $query->where('Kategori', $request->kategori);
            }

            // Filter Status
            if ($request->has('status') && !empty($request->status)) {
                $query->where('Status', $request->status);
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

                    return '<div class="font-weight-bold text-dark mb-1" style="font-size:14px; line-height: 1.3;">' . e($judul) . '</div>' .
                        '<small class="text-muted" style="font-size:12px;">Oleh: ' . e($penulis) . '</small>';
                })
                ->addColumn('TanggalPublikasi', function ($row) {
                    if (!$row->created_at)
                        return '-';
                    return '<div class="font-weight-bold text-dark" style="font-size:13px;">' . $row->created_at->translatedFormat('d M Y') . '</div>' .
                        '<small class="text-muted" style="font-size:11px;">' . $row->created_at->format('H:i') . ' WIB</small>';
                })
                ->addColumn('StatusBadge', function ($row) {
                    // Konfigurasi Badge Pills ala contoh tampilan
                    if ($row->Status === 'Draf') {
                        return '<span class="badge badge-pill badge-warning text-dark px-3 py-1" style="background-color: #FFF3CD; border: 1px solid #FFEEBA;"><i class="fa fa-circle mr-1 text-warning" style="font-size:8px;"></i> Draf</span>';
                    } elseif ($row->Status === 'Diterbitkan' || $row->Status === 'Terbit') {
                        return '<span class="badge badge-pill badge-success px-3 py-1" style="background-color: #D4EDDA; color: #155724; border: 1px solid #C3E6CB;"><i class="fa fa-circle mr-1 text-success" style="font-size:8px;"></i> Terbit</span>';
                    }
                    return '<span class="badge badge-pill badge-secondary px-3 py-1">' . e($row->Status) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    // Tombol aksi clean tanpa background tebal (flat icon look)
                    $btn = '<div class="d-flex align-items-center justify-content-start" style="gap: 12px;">';
                    $btn .= '<a href="' . url('news/' . $row->Slug) . '" target="_blank" class="text-secondary" title="Lihat"><i class="far fa-eye" style="font-size:16px;"></i></a>';
                    $btn .= '<a href="' . route('berita.edit', $row->Slug) . '" class="text-secondary" title="Edit"><i class="far fa-edit" style="font-size:16px;"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="text-secondary btn-delete" data-id="' . $row->id . '" title="Hapus"><i class="far fa-trash-alt" style="font-size:16px;"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['Thumbnail', 'Judul', 'TanggalPublikasi', 'StatusBadge', 'action'])
                ->make(true);
        }

        return view('pages.admin.berita.index');
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
            'Kategori' => 'required|string|max:100',
            'Tags' => 'nullable|string',
            'PathThumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Status' => 'required|in:Draf,Diterbitkan,Arsip',
            'TanggalPublikasi' => 'nullable|date',
            'Penulis' => 'nullable|string|max:100',

            'translations.id.Judul' => 'required|string|max:255',
            'translations.id.Ringkasan' => 'nullable|string',
            'Konten' => 'required|string',
            'translations.id.SEOTitle' => 'nullable|string|max:70',
            'translations.id.SEODescription' => 'nullable|string|max:160',
            'translations.id.SEOKeywords' => 'nullable|string|max:255',
            'translations.en.Judul' => 'nullable|string|max:255',
            'translations.en.Ringkasan' => 'nullable|string',
            'translations.en.Konten' => 'nullable|string',
        ]);
        if ($request->hasFile('PathThumbnail')) {
            $validated['PathThumbnail'] = $request->file('PathThumbnail')->store('berita/thumbnail', 'public');
        }
        $mainData = [
            'Kategori' => $validated['Kategori'],
            'Tags' => is_array($validated['Tags']) ? implode(', ', $validated['Tags']) : $validated['Tags'],
            'PathThumbnail' => $validated['PathThumbnail'],
            'Status' => $validated['Status'],
            'TanggalPublikasi' => $validated['TanggalPublikasi'],
            'Penulis' => $validated['Penulis'] ?? auth()->user()->name,
            'UserCreate' => auth()->user()->name,
            'Slug' => Str::slug($validated['translations']['id']['Judul']) . '-' . time(),
        ];
        $berita = Berita::create($mainData);
        $translationsData = $request->input('translations', []);
        $translationsData['id']['Konten'] = $validated['Konten'];
        foreach ($translationsData as $locale => $trans) {
            if (!empty($trans['Judul']) || !empty($trans['Konten'])) {
                $berita->translations()->create([
                    'Locale' => $locale,
                    'Judul' => $trans['Judul'] ?? null,
                    'Ringkasan' => $trans['Ringkasan'] ?? null,
                    'Konten' => $trans['Konten'] ?? null,
                    'SEOTitle' => $trans['SEOTitle'] ?? null,
                    'SEODescription' => $trans['SEODescription'] ?? null,
                    'SEOKeywords' => $trans['SEOKeywords'] ?? null,
                ]);
            }
        }

        // Activity Log
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
        // dd($id);
        $berita = Berita::where('Slug', $id)->first();
        // dd($berita);
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
            'PathThumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Status' => 'required|in:Draf,Diterbitkan,Arsip',
            'TanggalPublikasi' => 'nullable|date',
            'Penulis' => 'nullable|string|max:100',

            // Indonesia (Flat names sesuai permintaan)
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
            if ($berita->PathThumbnail && Storage::disk('public')->exists($berita->PathThumbnail)) {
                Storage::disk('public')->delete($berita->PathThumbnail);
            }
            $validated['PathThumbnail'] = $request->file('PathThumbnail')->store('berita/thumbnail', 'public');
        }

        // Data Utama (Non-translatable)
        $mainData = [
            'Kategori' => $validated['Kategori'],
            'Tags' => is_array($validated['Tags']) ? implode(', ', $validated['Tags']) : $validated['Tags'],
            'Status' => $validated['Status'],
            'TanggalPublikasi' => $validated['TanggalPublikasi'],
            'Penulis' => $validated['Penulis'],
            'UserUpdate' => auth()->user()->name,
        ];

        if (isset($validated['PathThumbnail'])) {
            $mainData['PathThumbnail'] = $validated['PathThumbnail'];
        }

        // Update Slug jika Judul berubah
        if ($berita->Judul !== $validated['Judul']) {
            $mainData['Slug'] = Str::slug($validated['Judul']) . '-' . time();
        }

        $berita->update($mainData);

        // Siapkan Data Translasi
        $translationsData = $request->input('translations', []);

        // ✅ PENTING: Masukkan field flat Indonesia ke dalam array translations[id]
        $translationsData['id'] = [
            'Judul' => $validated['Judul'],
            'Ringkasan' => $validated['Ringkasan'] ?? null,
            'Konten' => $validated['Konten'],
            'SEOTitle' => $validated['SEOTitle'] ?? null,
            'SEODescription' => $validated['SEODescription'] ?? null,
            'SEOKeywords' => $validated['SEOKeywords'] ?? null,
        ];

        // Update/Create ke Tabel Translasi
        foreach ($translationsData as $locale => $trans) {
            if (!empty($trans['Judul']) || !empty($trans['Konten'])) {
                $berita->translations()->updateOrCreate(
                    ['Locale' => $locale],
                    [
                        'Judul' => $trans['Judul'] ?? null,
                        'Ringkasan' => $trans['Ringkasan'] ?? null,
                        'Konten' => $trans['Konten'] ?? null,
                        'SEOTitle' => $trans['SEOTitle'] ?? null,
                        'SEODescription' => $trans['SEODescription'] ?? null,
                        'SEOKeywords' => $trans['SEOKeywords'] ?? null,
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
        // 1. Ambil bahasa yang sedang aktif ('id' atau 'en')
        $locale = app()->getLocale();

        // 2. Query dasar: Hanya ambil berita yang diterbitkan
        $query = Berita::where('Status', 'Diterbitkan');

        // 3. Eager Load translations sesuai bahasa aktif (Mencegah N+1 Query Problem)
        $query->with([
            'translations' => function ($q) use ($locale) {
                $q->where('Locale', $locale);
            }
        ]);

        // 4. Fitur Pencarian (Cari di dalam tabel terjemahan, bukan tabel utama)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('translations', function ($q) use ($search, $locale) {
                $q->where('Locale', $locale)
                    ->where(function ($subQ) use ($search) {
                        $subQ->where('Judul', 'like', '%' . $search . '%')
                            ->orWhere('Ringkasan', 'like', '%' . $search . '%');
                    });
            });
        }

        // 5. Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('Kategori', $request->kategori);
        }

        // 6. Filter Tag
        if ($request->filled('tag')) {
            $query->where('Tags', 'like', '%' . $request->tag . '%');
        }

        // Eksekusi Query untuk List Utama
        $news = $query->latest('TanggalPublikasi')->paginate(10);

        // 7. Recent News (Sidebar) - Juga perlu eager load translation
        $recentNews = Berita::where('Status', 'Diterbitkan')
            ->with([
                'translations' => function ($q) use ($locale) {
                    $q->where('Locale', $locale);
                }
            ])
            ->latest('TanggalPublikasi')
            ->take(3)
            ->get();

        // 8. Categories (Kategori tidak diterjemahkan di tabel ini, jadi ambil dari tabel utama)
        $categories = Berita::where('Status', 'Diterbitkan')
            ->select('Kategori')
            ->distinct()
            ->pluck('Kategori')
            ->filter();

        // Kirim $locale ke view agar bisa digunakan di Blade
        return view('frontend.news', compact('news', 'recentNews', 'categories', 'locale'));
    }

    public function newsDetail($locale, $slug)
    {
        $locale = app()->getLocale();

        // 1. Main News: Eager load translation sesuai bahasa aktif
        $news = Berita::with([
            'translations' => function ($q) use ($locale) {
                $q->where('Locale', $locale);
            }
        ])->where('Slug', $slug)->firstOrFail();

        // 2. Recent News (Sidebar): Eager load translation
        $recentNews = Berita::with([
            'translations' => function ($q) use ($locale) {
                $q->where('Locale', $locale);
            }
        ])
            ->where('id', '!=', $news->id)
            ->where('Status', 'Diterbitkan')
            ->latest('TanggalPublikasi')
            ->take(3)
            ->get();

        // 3. Categories (Data ini tidak diterjemahkan di tabel terpisah, ambil dari utama)
        $categories = Berita::where('Status', 'Diterbitkan')
            ->select('Kategori')
            ->distinct()
            ->pluck('Kategori')
            ->filter();

        // 4. Prev/Next Posts: Eager load translation
        $prevPost = Berita::with([
            'translations' => function ($q) use ($locale) {
                $q->where('Locale', $locale);
            }
        ])
            ->where('TanggalPublikasi', '<', $news->TanggalPublikasi)
            ->where('Status', 'Diterbitkan')
            ->latest('TanggalPublikasi')
            ->first();

        $nextPost = Berita::with([
            'translations' => function ($q) use ($locale) {
                $q->where('Locale', $locale);
            }
        ])
            ->where('TanggalPublikasi', '>', $news->TanggalPublikasi)
            ->where('Status', 'Diterbitkan')
            ->oldest('TanggalPublikasi')
            ->first();

        // 5. Related Posts: Eager load translation
        $relatedPosts = Berita::with([
            'translations' => function ($q) use ($locale) {
                $q->where('Locale', $locale);
            }
        ])
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
            'locale' // Kirim locale ke view
        ));
    }
}
