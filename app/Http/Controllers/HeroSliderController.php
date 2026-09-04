<?php

namespace App\Http\Controllers;

use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HeroSliderController extends Controller
{
    /** Display a listing of the resource. */

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = HeroSlider::orderBy('Urutan');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <div class="btn-group btn-group-sm">
                        <a href="' . route('hero-slider.edit', $row->id) . '" class="btn btn-warning" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                ';
                })

                ->addColumn('GambarLatar', function ($row) {
                    // Menampilkan preview bisa berupa gambar ATAU ikon video sesuai TipeMedia
                    if ($row->TipeMedia === 'video' && $row->Video) {
                        return '<i class="fa fa-film text-muted" style="font-size: 24px;" title="Video: ' . htmlspecialchars($row->Video) . '"></i>';
                    }
                    if ($row->GambarLatar) {
                        $url = asset('storage/' . $row->GambarLatar);
                        return '<img src="' . $url . '" alt="Gambar Latar" style="height:40px;max-width:60px;object-fit:contain;">';
                    }
                    return '<span class="text-muted">-</span>';
                })

                ->addColumn('GambarBentuk', function ($row) {
                    if ($row->GambarBentuk) {
                        $url = asset('storage/' . $row->GambarBentuk);
                        return '<img src="' . $url . '" alt="Gambar Bentuk" style="height:40px;max-width:60px;object-fit:contain;">';
                    } else {
                        return '<span class="text-muted">-</span>';
                    }
                })
                ->addColumn('Status', function ($row) {
                    if ($row->Status == 1) {
                        return '<span class="badge bg-success">Aktif</span>';
                    } elseif ($row->Status == 2) {
                        return '<span class="badge bg-secondary">Tidak Aktif</span>';
                    } else {
                        return '<span class="badge bg-light text-dark">Tidak Diketahui</span>';
                    }
                })

                ->rawColumns(['action', 'GambarLatar', 'GambarBentuk', 'Status'])
                ->make(true);
        }

        return view('pengaturan.landing-page.hero-slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengaturan.landing-page.hero-slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'SubJudul' => 'nullable|string|max:255',
            'JudulUtama' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string|max:500',
            'TipeMedia' => 'required|in:image,video',
            'GambarLatar' => 'nullable|file|image|max:2048',
            'Video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:20480', // max 20MB
            'GambarBentuk' => 'nullable|file|image|max:2048',
            'TeksCTA' => 'nullable|string|max:100',
            'LinkCTA' => 'nullable|url|max:255',
            'TeksCTA2' => 'nullable|string|max:100',
            'LinkCTA2' => 'nullable|url|max:255',
            'Status' => 'nullable|boolean',
        ]);

        $data = [
            'SubJudul' => $request->SubJudul,
            'JudulUtama' => $request->JudulUtama,
            'Deskripsi' => $request->Deskripsi,
            'TipeMedia' => $request->TipeMedia,
            'TeksCTA' => $request->TeksCTA,
            'LinkCTA' => $request->LinkCTA,
            'TeksCTA2' => $request->TeksCTA2,
            'LinkCTA2' => $request->LinkCTA2,
            'Status' => $request->Status ? 1 : 0,
            'Urutan' => $request->Urutan ?? ((HeroSlider::max('Urutan') ?? 0) + 1),
            'UserCreate' => auth()->user()?->name,
        ];

        // Upload Gambar Latar
        if ($request->hasFile('GambarLatar')) {
            $data['GambarLatar'] = $request->file('GambarLatar')
                ->store('hero-sliders/backgrounds', 'public');
        }

        // Upload Video
        if ($request->hasFile('Video')) {
            $data['Video'] = $request->file('Video')
                ->store('hero-sliders/videos', 'public');
        }

        // Upload Gambar Bentuk (overlay decoration)
        if ($request->hasFile('GambarBentuk')) {
            $data['GambarBentuk'] = $request->file('GambarBentuk')
                ->store('hero-sliders/shapes', 'public');
        }

        HeroSlider::create($data);

        return redirect()->route('hero-slider.index')
            ->with('success', 'Hero Slider berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroSlider $heroSlider)
    {
        // Not implemented. Use index or API if needed.
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $heroSlider = HeroSlider::findOrFail($id);
        return view('pengaturan.landing-page.hero-slider.edit', compact('heroSlider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'TipeMedia' => 'required|in:image,video',
            'JudulUtama' => 'required|string|max:255',
            'SubJudul' => 'nullable|string|max:255',
            'Deskripsi' => 'nullable|string|max:1000',
            'GambarLatar' => 'nullable|file|image|max:2048', // Maks 2MB
            'Video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:20480', // Maks 20MB
            'GambarBentuk' => 'nullable|file|image|max:2048',
            'TeksCTA' => 'nullable|string|max:100',
            'LinkCTA' => 'nullable|url|max:255',
            'TeksCTA2' => 'nullable|string|max:100',
            'LinkCTA2' => 'nullable|url|max:255',
            'Urutan' => 'required|integer|min:1',
            'Status' => 'nullable|boolean',
        ]);

        $heroSlider = HeroSlider::findOrFail($id);
        $disk = \Illuminate\Support\Facades\Storage::disk('public');

        // 2. Handle Upload & Hapus Gambar Latar Lama
        $gambarLatarPath = $heroSlider->GambarLatar;
        if ($request->hasFile('GambarLatar')) {
            if ($gambarLatarPath && $disk->exists($gambarLatarPath)) {
                $disk->delete($gambarLatarPath);
            }
            $gambarLatarPath = $request->file('GambarLatar')->store('hero-sliders/backgrounds', 'public');
        }

        // 3. Handle Upload & Hapus Video Lama
        $videoPath = $heroSlider->Video;
        if ($request->hasFile('Video')) {
            if ($videoPath && $disk->exists($videoPath)) {
                $disk->delete($videoPath);
            }
            $videoPath = $request->file('Video')->store('hero-sliders/videos', 'public');
        }

        // 4. Handle Upload & Hapus Gambar Bentuk Lama
        $gambarBentukPath = $heroSlider->GambarBentuk;
        if ($request->hasFile('GambarBentuk')) {
            if ($gambarBentukPath && $disk->exists($gambarBentukPath)) {
                $disk->delete($gambarBentukPath);
            }
            $gambarBentukPath = $request->file('GambarBentuk')->store('hero-sliders/shapes', 'public');
        }

        // 5. Update Data ke Database
        $heroSlider->update([
            'TipeMedia' => $request->TipeMedia,
            'SubJudul' => $request->SubJudul,
            'JudulUtama' => $request->JudulUtama,
            'Deskripsi' => $request->Deskripsi,
            'GambarLatar' => $gambarLatarPath,
            'Video' => $videoPath,
            'GambarBentuk' => $gambarBentukPath,
            'TeksCTA' => $request->TeksCTA,
            'LinkCTA' => $request->LinkCTA,
            'TeksCTA2' => $request->TeksCTA2,
            'LinkCTA2' => $request->LinkCTA2,
            'Urutan' => $request->Urutan,
            'Status' => $request->Status ? 1 : 0,
            'UserUpdate' => auth()->check() ? auth()->user()->name : 'System',
        ]);

        // Catatan: Sesuaikan 'hero-slider.index' dengan nama route Anda jika berbeda (misal: 'pengaturan-hero-slider.index')
        return redirect()->route('hero-slider.index')->with('success', 'Hero Slider berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $heroSlider = HeroSlider::findOrFail($id);
            $disk = \Illuminate\Support\Facades\Storage::disk('public');

            // 1. Hapus file-file terkait dari storage
            if ($heroSlider->GambarLatar && $disk->exists($heroSlider->GambarLatar)) {
                $disk->delete($heroSlider->GambarLatar);
            }
            if ($heroSlider->GambarBentuk && $disk->exists($heroSlider->GambarBentuk)) {
                $disk->delete($heroSlider->GambarBentuk);
            }
            if (!empty($heroSlider->Video) && $disk->exists($heroSlider->Video)) {
                $disk->delete($heroSlider->Video);
            }

            // 2. Catat siapa yang menghapus (Hanya berguna jika menggunakan SoftDeletes)
            $heroSlider->UserDelete = auth()->check() ? auth()->user()->name : 'System';

            // 3. Hapus record
            // Gunakan delete() jika model punya trait SoftDeletes.
            // Jika ingin hard delete total, gunakan forceDelete() (tapi UserDelete akan hilang).
            $heroSlider->delete();

            // 4. Return JSON dengan key 'message' agar cocok dengan JS
            return response()->json([
                'message' => 'Hero Slider berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }
}
