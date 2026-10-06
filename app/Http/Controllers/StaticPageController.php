<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class StaticPageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StaticPage::with('translations')->orderBy('Urutan');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('JudulDisplay', function ($row) {
                    $id = $row->translate('id')->Judul ?: '-';
                    $en = $row->translate('en')->Judul ?: '';

                    $html = '<div class="d-flex align-items-center">';
                    $html .= '<div class="mr-3" style="width:40px;height:40px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">';
                    $html .= '<i class="' . ($row->Icon ?: 'fa fa-file') . ' text-primary" style="font-size:18px;"></i>';
                    $html .= '</div>';
                    $html .= '<div><strong class="text-dark">' . $row->Label . '</strong>';
                    $html .= '<br><small class="text-muted">' . $id . '</small>';
                    if ($en) {
                        $html .= '<br><small class="text-muted"><i class="fa fa-globe mr-1"></i>' . $en . '</small>';
                    }
                    $html .= '</div></div>';
                    return $html;
                })
                ->addColumn('Slug', function ($row) {
                    return '<code>/' . ($row->Slug ?: '-') . '</code>';
                })
                ->addColumn('Status', function ($row) {
                    return $row->IsPublished
                        ? '<span class="badge badge-success px-2 py-1">Published</span>'
                        : '<span class="badge badge-secondary px-2 py-1">Draft</span>';
                })
                ->addColumn('LastUpdate', function ($row) {
                    return $row->updated_at ? $row->updated_at->diffForHumans() : '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('static-pages.edit', $row->id) . '" class="btn btn-sm btn-warning mr-1" title="Edit">';
                    $btn .= '<i class="fa fa-edit"></i> Edit</a>';

                    if ($row->IsPublished && $row->Slug) {
                        $showUrl = url('id/' . $row->Slug);

                        $btn .= '<a href="' . $showUrl . '" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat Halaman">';
                        $btn .= '<i class="fa fa-eye"></i></a>';
                    }

                    return $btn;
                })
                ->addColumn('raw_slug', function ($row) {
                    return $row->Slug;
                })
                ->addColumn('raw_is_published', function ($row) {
                    return $row->IsPublished;
                })
                ->rawColumns(['JudulDisplay', 'Slug', 'Status', 'action']) // ← raw_slug & raw_is_published TIDAK di-rawColumns
                ->make(true);
        }

        return view('pages.admin.static-pages.index');
    }

    public function edit($id)
    {
        // dd($id);
        $page = StaticPage::with('translations')->findOrFail($id);
        return view('pages.admin.static-pages.edit', compact('page'));
    }
    public function show(Request $request, $locale, $slug)
    {
        $locale = app()->getLocale();
        $page = StaticPage::with([
            'translations' => function ($q) use ($locale) {
                $q->where('Locale', $locale);
            }
        ])
            ->where('Slug', $slug)
            ->where('IsPublished', true)
            ->firstOrFail();

        $translation = $page->translate($locale);
        if (empty($translation->Judul)) {
            $translation = $page->translate('id');
        }

        return view('frontend.static-pages.show', compact('page', 'translation', 'locale'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'translations.id.Judul' => 'required|string|max:255',
            'translations.id.Konten' => 'nullable|string',
            'translations.id.SEOTitle' => 'nullable|string|max:70',
            'translations.id.SEODescription' => 'nullable|string|max:160',
            'translations.id.SEOKeywords' => 'nullable|string|max:255',
            'translations.en.Judul' => 'nullable|string|max:255',
            'translations.en.Konten' => 'nullable|string',
            'translations.en.SEOTitle' => 'nullable|string|max:70',
            'translations.en.SEODescription' => 'nullable|string|max:160',
            'translations.en.SEOKeywords' => 'nullable|string|max:255',
            'Slug' => 'nullable|string|max:255',
            'Thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'IsPublished' => 'nullable|boolean',
        ]);

        $page = StaticPage::findOrFail($id);

        $page->update([
            'Slug' => $validated['Slug'] ?? null,
            'IsPublished' => $request->has('IsPublished'),
            'UserUpdate' => auth()->user()->name,
        ]);

        if ($request->hasFile('Thumbnail')) {
            if ($page->Thumbnail && Storage::disk('public')->exists($page->Thumbnail)) {
                Storage::disk('public')->delete($page->Thumbnail);
            }
            $page->Thumbnail = $request->file('Thumbnail')->store('static-pages', 'public');
            $page->save();
        }

        // Update translations
        foreach (['id', 'en'] as $locale) {
            $transData = $validated['translations'][$locale] ?? [];
            if (!empty($transData['Judul'])) {
                $page->translations()->updateOrCreate(
                    ['Locale' => $locale],
                    [
                        'Judul' => $transData['Judul'],
                        'Konten' => $transData['Konten'] ?? null,
                        'SEOTitle' => $transData['SEOTitle'] ?? null,
                        'SEODescription' => $transData['SEODescription'] ?? null,
                        'SEOKeywords' => $transData['SEOKeywords'] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('static-pages.index')
            ->with('success', 'Halaman "' . $page->Label . '" berhasil diperbarui.');
    }

    /**
     * Upload gambar dari Summernote (sama seperti Berita)
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('static-pages/editor', 'public');
            return response()->json([
                'url' => asset('storage/' . $path),
            ]);
        }

        return response()->json(['error' => 'Upload gagal'], 400);
    }
}
