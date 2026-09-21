<?php

namespace App\Http\Controllers;

use App\Models\HalamanSolusi;
use App\Models\HalamanSolusiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Str;

class HalamanSolusiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = HalamanSolusi::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Judul', function ($row) {
                    return $row->Judul;
                })
                ->addColumn('Slug', function ($row) {
                    return $row->Slug;
                })
                ->addColumn('Konten', function ($row) {
                    return Str::limit(strip_tags($row->Konten), 100);
                })
                ->addColumn('action', function ($row) {
                    $encryptedId = encrypt($row->id);
                    $btn = '<div class="btn-group btn-group-sm">';
                    // Show button with slug
                    $btn .= '<a href="' . route('halaman-solusi.show', $row->Slug) . '" class="btn btn-info" title="Show" target="_blank"><i class="fa fa-eye"></i></a>';
                    $btn .= '<a href="' . route('halaman-solusi.edit', $encryptedId) . '" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>';
                    $btn .= '<button class="btn btn-danger btn-delete" data-id="' . $encryptedId . '" title="Hapus"><i class="fa fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
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

    return redirect()->route('halaman-solusi.index')->with('success', 'Solusi berhasil disimpan.');
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $halamanSolusi = HalamanSolusi::with('getSolusiDetail')->where('Slug', $id)->firstOrFail();
        return view('pages.admin.halaman-solusi.show', compact('halamanSolusi'));
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
            $oldDetail->delete(); // Cascade delete akan otomatis menghapus translations-nya
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
