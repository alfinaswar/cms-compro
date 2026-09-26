<?php

namespace App\Http\Controllers;

use App\Models\CustomPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomPagesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CustomPage::with(['translations', 'children', 'parent'])
                ->orderBy('ParentId')
                ->orderBy('Urutan', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('JudulDisplay', function ($row) {
                    $trans = $row->translations->firstWhere('Locale', 'id');
                    $nama = $trans ? $trans->Judul : $row->Judul;

                    $icon = $row->children->count() > 0
                        ? '<i class="fa fa-folder-open mr-2 text-warning"></i>'
                        : '<i class="fa fa-file-alt mr-2 text-primary"></i>';

                    $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $row->level);
                    $badge = $row->children->count() > 0
                        ? '<span class="badge badge-info badge-sm ml-2">Parent (' . $row->children->count() . ' Sub)</span>'
                        : '';

                    return $indent . $icon . '<strong>' . $nama . '</strong>' . $badge;
                })
                ->addColumn('Thumbnail', function ($row) {
                    return $row->Thumbnail
                        ? '<img src="' . Storage::url($row->Thumbnail) . '" style="width:80px;height:50px;object-fit:cover;border-radius:4px;">'
                        : '<span class="text-muted">No Image</span>';
                })
                // Change from 'Status' to 'StatusBadge' for badge according to the request.
                ->addColumn('StatusBadge', function ($row) {
                    return $row->IsPublished
                        ? '<span class="badge badge-success" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">Diterbitkan</span>'
                        : '<span class="badge badge-secondary" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">Draf</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('frontend.halaman-custom', $row->Slug) . '" class="btn btn-info btn-sm" title="Show"><i class="fa fa-eye"></i></a> ';
                    $btn .= '<a href="' . route('custom-pages.edit', $row->id) . '" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" data-nama="' . $row->translate('id')->Judul . '" title="Hapus"><i class="fa fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['JudulDisplay', 'Thumbnail', 'StatusBadge', 'action'])
                ->make(true);
        }

        $allPages = CustomPage::with('translations')->orderBy('Urutan')->get();
        $parentPages = CustomPage::whereNull('ParentId')->orderBy('Urutan')->get();

        return view('pages.admin.custom-pages.index', compact('allPages', 'parentPages'));
    }

    public function create()
    {
        $parentPages = CustomPage::whereNull('ParentId')->orderBy('Urutan')->get();
        return view('pages.admin.custom-pages.create', compact('parentPages'));
    }

    public function store(Request $request)
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

            'ParentId' => 'nullable|exists:custom_pages,id',
            'Slug' => 'nullable|string|max:255',
            'Urutan' => 'nullable|integer',
            'IsPublished' => 'required|in:0,1',
            'Thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $page = new CustomPage();
        $page->ParentId = $request->ParentId ?: null;
        $page->Slug = $request->Slug ?: Str::slug($validated['translations']['id']['Judul']);
        $page->Urutan = $request->Urutan ?? 0;
        $page->IsPublished = $request->IsPublished;
        $page->UserCreate = auth()->user()->name;

        if ($request->hasFile('Thumbnail')) {
            $page->Thumbnail = $request->file('Thumbnail')->store('custom-pages/thumbnail', 'public');
        }
        $page->save();

        // Simpan Translations
        foreach (['id', 'en'] as $locale) {
            if (!empty($validated['translations'][$locale]['Judul'])) {
                $page->translations()->create([
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

        return redirect()->route('custom-pages.index')->with('success', 'Halaman berhasil ditambahkan.');
    }
    public function show($locale, $slug)
    {
        // dd();
        $locale = app()->getLocale();
        $page = CustomPage::with([
            'translations' => fn($q) => $q->where('Locale', $locale),
            'parent' => fn($q) => $q->with(['translations' => fn($tq) => $tq->where('Locale', $locale)]),
            'children' => fn($q) => $q->with(['translations' => fn($tq) => $tq->where('Locale', $locale)])
                ->where('IsPublished', true)
                ->orderBy('Urutan')
        ])->where('Slug', $slug)
            ->where('IsPublished', true)
            ->firstOrFail();

        // Opsional: Ambil berita terbaru untuk sidebar (cross-linking)
        $recentNews = \App\Models\Berita::where('Status', 'Diterbitkan')
            ->with(['translations' => fn($q) => $q->where('Locale', $locale)])
            ->latest('TanggalPublikasi')
            ->take(3)
            ->get();

        return view('frontend.custom-pages.show', compact('page', 'locale', 'recentNews'));
    }
    public function edit($id)
    {
        $page = CustomPage::with('translations')->findOrFail($id);
        $parentPages = CustomPage::whereNull('ParentId')
            ->where('id', '!=', $id)
            ->orderBy('Urutan')
            ->get();

        return view('pages.admin.custom-pages.edit', compact('page', 'parentPages'));
    }

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

            'ParentId' => 'nullable|exists:CustomPages,id',
            'Slug' => 'nullable|string|max:255',
            'Urutan' => 'nullable|integer',
            'IsPublished' => 'required|in:0,1',
            'Thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $page = CustomPage::findOrFail($id);

        // Cegah circular reference (page tidak bisa jadi parent dari dirinya sendiri)
        if ($request->ParentId == $id) {
            return back()->with('error', 'Halaman tidak bisa menjadi parent dari dirinya sendiri.');
        }

        $page->ParentId = $request->ParentId ?: null;
        $page->Slug = $request->Slug ?: Str::slug($validated['translations']['id']['Judul']);
        $page->Urutan = $request->Urutan ?? 0;
        $page->IsPublished = $request->IsPublished;
        $page->UserUpdate = auth()->user()->name;

        if ($request->hasFile('Thumbnail')) {
            if ($page->Thumbnail && Storage::disk('public')->exists($page->Thumbnail)) {
                Storage::disk('public')->delete($page->Thumbnail);
            }
            $page->Thumbnail = $request->file('Thumbnail')->store('custom-pages/thumbnail', 'public');
        }
        $page->save();

        // Update Translations
        foreach (['id', 'en'] as $locale) {
            $page->translations()->updateOrCreate(
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

        return redirect()->route('custom-pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $page = CustomPage::findOrFail($id);

        // Cek apakah punya children
        if ($page->children()->count() > 0) {
            return response()->json(['status' => 400, 'message' => 'Tidak bisa menghapus halaman yang memiliki sub-halaman. Hapus sub-halaman terlebih dahulu.'], 400);
        }

        if ($page->Thumbnail && Storage::disk('public')->exists($page->Thumbnail)) {
            Storage::disk('public')->delete($page->Thumbnail);
        }

        $page->delete();

        return response()->json(['status' => 200, 'message' => 'Halaman berhasil dihapus.']);
    }
}
