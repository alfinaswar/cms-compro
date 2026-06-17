<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\AboutUsDetail;
use App\Models\HistoryPerusahaan;
use App\Models\PenghargaanPerusahaan;
use App\Models\ValuePerusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AboutUs::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('SubJudul', function ($row) {
                    return $row->SubJudul ? $row->SubJudul : '<span class="text-muted">-</span>';
                })
                ->addColumn('Judul', function ($row) {
                    return $row->Judul ? $row->Judul : '<span class="text-muted">-</span>';
                })
                ->addColumn('Deskripsi', function ($row) {
                    if ($row->Deskripsi) {
                        $plainText = strip_tags($row->Deskripsi);
                        if (mb_strlen($plainText) > 100) {
                            return mb_substr($plainText, 0, 100) . '...';
                        }
                        return $plainText;
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->addColumn('Gambar', function ($row) {
                    if ($row->Gambar) {
                        return '<img src="' . asset('storage/' . $row->Gambar) . '" width="80" class="img-thumbnail">';
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('about-us.edit', encrypt($row->id));
                    $btn = '<a href="' . $editUrl . '" class="btn btn-warning btn-sm mr-1 text-white" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>';
                    $btn .= '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>';
                    return $btn;
                })
                ->rawColumns(['SubJudul', 'Judul', 'Deskripsi', 'Gambar', 'action'])
                ->make(true);
        }

        return view('pengaturan.landing-page.about.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengaturan.landing-page.about.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'SubJudul' => 'nullable|string',
            'Judul' => 'required|string|max:255',
            'Deskripsi' => 'required|string',
            'Gambar' => 'nullable|file|image|max:2048',
            'Status' => 'required|in:0,1',
            // Validasi array details
            'details' => 'nullable|array',
            'details.*.Judul' => 'required|string|max:255',
            'details.*.Deskripsi' => 'required|string',
            'details.*.Gambar' => 'nullable|file|image|max:2048',
        ], [
            'details.*.Judul.required' => 'Judul detail ke-:attribute wajib diisi.',
            'details.*.Deskripsi.required' => 'Deskripsi detail ke-:attribute wajib diisi.',
            'details.*.Gambar.image' => 'File detail ke-:attribute harus berupa gambar.',
            'details.*.Gambar.max' => 'Ukuran gambar detail ke-:attribute maksimal 2MB.',
        ]);

        $gambarPath = null;
        if ($request->hasFile('Gambar')) {
            $gambar = $request->file('Gambar');
            $gambarPath = $gambar->store('about-us', 'public');
        }
        $aboutUs = AboutUs::create([
            'SubJudul' => $request->SubJudul,
            'Judul' => $request->Judul,
            'Deskripsi' => $request->Deskripsi,
            'Gambar' => $gambarPath,
            'Status' => $request->Status,
            'UserCreate' => auth()->check() ? auth()->user()->name : null,
        ]);
        if ($request->has('details') && is_array($request->details)) {
            foreach ($request->details as $detail) {
                if (empty($detail['Judul']) && empty($detail['Deskripsi'])) {
                    continue;
                }
                $detailGambarPath = null;
                if (isset($detail['Gambar']) && $detail['Gambar'] instanceof \Illuminate\Http\UploadedFile) {
                    $detailGambarPath = $detail['Gambar']->store('about-us/details', 'public');
                }

                AboutUsDetail::create([
                    'IdAbout' => $aboutUs->id,
                    'Judul' => $detail['Judul'] ?? null,
                    'Deskripsi' => $detail['Deskripsi'] ?? null,
                    'Gambar' => $detailGambarPath,
                ]);
            }
        }

        return redirect()->route('about-us.index')->with('success', 'About Us berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AboutUs $aboutUs)
    {
        $Riwayat = AboutUs::with('getDetail')->find('1');
        $Value = AboutUs::with('getDetail')->find('2');
        $TanggungJawab = AboutUs::with('getDetail')->find('3');
        $Award = AboutUs::with('getDetail')->find('4');
        return view('frontend.about', compact('Riwayat', 'Value', 'TanggungJawab', 'Award'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $aboutUs = AboutUs::with('getDetail')->findOrFail($id);
        // dd($aboutUs);
        return view('pengaturan.landing-page.about.edit', compact('aboutUs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'SubJudul' => 'nullable|string',
            'Judul' => 'required|string|max:255',
            'Deskripsi' => 'required|string',
            'Gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $aboutUs = AboutUs::findOrFail($id);

        $gambarPath = $aboutUs->Gambar;

        if ($request->hasFile('Gambar')) {
            if ($gambarPath && Storage::disk('public')->exists($gambarPath)) {
                Storage::disk('public')->delete($gambarPath);
            }
            $gambarPath = $request->file('Gambar')->store('about-us', 'public');
        }

        $aboutUs->update([
            'SubJudul' => $request->SubJudul,
            'Judul' => $request->Judul,
            'Deskripsi' => $request->Deskripsi,
            'Gambar' => $gambarPath,
            'UserUpdate' => auth()->check() ? auth()->user()->name : null,
        ]);

        return redirect()->route('about-us.index')->with('success', 'About Us berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $aboutUs = AboutUs::findOrFail($id);

        $aboutUs->UserDelete = auth()->check() ? auth()->user()->name : null;
        $aboutUs->save();
        $aboutUs->delete();

        return response()->json(['success' => 'About Us berhasil dihapus!']);
    }
}
