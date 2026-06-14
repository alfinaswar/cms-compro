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
            'Judul' => 'required|string|max:255',
            'Konten' => 'required|string',
            'Slug' => 'nullable|string|max:255',
            'DeskripsiSingkat' => 'nullable|string|max:255',
            'SEOTitle' => 'nullable|string|max:255',
            'SEODescription' => 'nullable|string|max:255',
            'SEOKeywords' => 'nullable|string|max:255',
            'IsPublished' => 'required|in:0,1',
            'Thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'detail' => 'required|array|min:1',
            'detail.*.judul' => 'required|string|max:255',
            'detail.*.keterangan' => 'nullable|string',
            'detail.*.gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        $thumbnailPath = null;
        if ($request->hasFile('Thumbnail')) {
            $thumbnailPath = $request->file('Thumbnail')->storeAs(
                'halaman-solusi/thumbnail',
                $request->file('Thumbnail')->hashName(),
                'public'
            );
        }

        $solusi = new HalamanSolusi();
        $solusi->Judul = $request->Judul;
        $solusi->Slug = $request->Slug ? $request->Slug : Str::slug($request->Judul);
        $solusi->Konten = $request->Konten;
        $solusi->SEOTitle = $request->SEOTitle;
        $solusi->SEODescription = $request->SEODescription;
        $solusi->SEOKeywords = $request->SEOKeywords;
        $solusi->IsPublished = $request->IsPublished;
        $solusi->UserCreate = auth()->user()->name;
        $solusi->Thumbnail = $thumbnailPath;
        $solusi->DeskripsiSingkat = $request->DeskripsiSingkat;

        $solusi->save();
        if (is_array($request->detail)) {
            foreach ($request->detail as $i => $det) {
                $detail = new HalamanSolusidetail();
                $detail->HalamanSolusiId = $solusi->id;
                $detail->Judul = $det['judul'] ?? '';
                $detail->Keterangan = $det['keterangan'] ?? null;
                if (isset($det['gambar']) && $request->hasFile("detail.$i.gambar")) {
                    $file = $request->file("detail.$i.gambar");
                    $detail->Gambar = $file->storeAs('halaman-solusi/detail', $file->hashName(), 'public');
                }
                $detail->save();
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
        $data = HalamanSolusi::with('getSolusiDetail')->find($id);
        // dd($data);
        return view('pages.admin.halaman-solusi.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'DeskripsiSingkat' => 'nullable|string|max:255',
            'Thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Konten' => 'required|string',
            'Slug' => 'nullable|string|max:255',
            'SEOTitle' => 'nullable|string|max:255',
            'SEODescription' => 'nullable|string|max:255',
            'SEOKeywords' => 'nullable|string|max:255',
            'IsPublished' => 'required|in:0,1',
            'detail' => 'required|array|min:1',
            'detail.*.judul' => 'required|string|max:255',
            'detail.*.keterangan' => 'nullable|string',
            'detail.*.gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $solusi = HalamanSolusi::findOrFail($id);

        $solusi->Judul = $request->Judul;
        $solusi->DeskripsiSingkat = $request->DeskripsiSingkat;

        // Handle Thumbnail upload (optional)
        if ($request->hasFile('Thumbnail')) {
            $file = $request->file('Thumbnail');
            $thumbnailPath = $file->storeAs('halaman-solusi', $file->hashName(), 'public');
            $solusi->Thumbnail = $thumbnailPath;
        }

        $solusi->Slug = $request->Slug ? $request->Slug : \Str::slug($request->Judul);
        $solusi->Konten = $request->Konten;
        $solusi->SEOTitle = $request->SEOTitle;
        $solusi->SEODescription = $request->SEODescription;
        $solusi->SEOKeywords = $request->SEOKeywords;
        $solusi->IsPublished = $request->IsPublished;
        $solusi->UserUpdate = auth()->user()->name;
        $solusi->save();

        HalamanSolusiDetail::where('HalamanSolusiId', $solusi->id)->delete();

        // Simpan detail baru
        if (is_array($request->detail)) {
            foreach ($request->detail as $i => $det) {
                $detail = new HalamanSolusiDetail();
                $detail->HalamanSolusiId = $solusi->id;
                $detail->Judul = $det['judul'] ?? '';
                $detail->Keterangan = $det['keterangan'] ?? null;
                if ($request->hasFile("detail.$i.gambar")) {
                    $file = $request->file("detail.$i.gambar");
                    $detail->Gambar = $file->storeAs('halaman-solusi/detail', $file->hashName(), 'public');
                }
                $detail->save();
            }
        }

        return redirect()->route('halaman-solusi.index')->with('success', 'Solusi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HalamanSolusi $halamanSolusi)
    {
        //
    }
}
