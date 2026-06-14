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
                    $encryptedId = encrypt($row->Id);
                    return '
                        <div class="btn-group btn-group-sm">
                            <a href="' . route('hero-slider.edit', $encryptedId) . '" class="btn btn-warning btn-edit" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-delete" data-id="' . $row->Id . '" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->addColumn('GambarLatar', function ($row) {
                    if ($row->GambarLatar) {
                        $url = asset('storage/' . $row->GambarLatar);
                        return '<img src="' . $url . '" alt="Gambar Latar" style="height:40px;max-width:60px;object-fit:contain;">';
                    } else {
                        return '<span class="text-muted">-</span>';
                    }
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
                    return $row->Status ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>';
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
            'GambarLatar' => 'nullable|file|image|max:2048',
            'GambarBentuk' => 'nullable|file|image|max:2048',
            'Status' => 'nullable|boolean',
        ]);

        $gambarLatarPath = null;
        if ($request->hasFile('GambarLatar')) {
            $gambarLatarPath = $request->file('GambarLatar')->store('hero-sliders/backgrounds', 'public');
        }

        $gambarBentukPath = null;
        if ($request->hasFile('GambarBentuk')) {
            $gambarBentukPath = $request->file('GambarBentuk')->store('hero-sliders/shapes', 'public');
        }

        $data = [
            'SubJudul' => $request->SubJudul,
            'JudulUtama' => $request->JudulUtama,
            'GambarLatar' => $gambarLatarPath,
            'GambarBentuk' => $gambarBentukPath,
            'Status' => $request->Status ? 1 : 0,
            'UserCreate' => auth()->user() ? auth()->user()->name : null,
        ];

        HeroSlider::create($data);

        return redirect()->route('hero-slider.index')->with('success', 'Hero Slider berhasil ditambahkan.');
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
        $id = decrypt($id);
        $heroSlider = HeroSlider::findOrFail($id);
        return view('pengaturan.landing-page.hero-slider.edit', compact('heroSlider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'SubJudul' => 'nullable|string|max:255',
            'JudulUtama' => 'required|string|max:255',
            'GambarLatar' => 'nullable|file|image|max:2048',
            'GambarBentuk' => 'nullable|file|image|max:2048',
            'Urutan' => 'required|integer',
            'Status' => 'nullable|boolean',
        ]);

        $heroSlider = HeroSlider::findOrFail($id);

        $gambarLatarPath = $heroSlider->GambarLatar;
        if ($request->hasFile('GambarLatar')) {
            if ($gambarLatarPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($gambarLatarPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($gambarLatarPath);
            }
            $gambarLatarPath = $request->file('GambarLatar')->store('hero-sliders/backgrounds', 'public');
        }

        $gambarBentukPath = $heroSlider->GambarBentuk;
        if ($request->hasFile('GambarBentuk')) {
            if ($gambarBentukPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($gambarBentukPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($gambarBentukPath);
            }
            $gambarBentukPath = $request->file('GambarBentuk')->store('hero-sliders/shapes', 'public');
        }

        $heroSlider->update([
            'SubJudul' => $request->SubJudul,
            'JudulUtama' => $request->JudulUtama,
            'GambarLatar' => $gambarLatarPath,
            'GambarBentuk' => $gambarBentukPath,
            'Urutan' => $request->Urutan,
            'Status' => $request->Status ? 1 : 0,
            'UserUpdate' => auth()->user() ? auth()->user()->name : null,
        ]);

        return redirect()->route('pengaturan-hero-slider.index')->with('success', 'Hero Slider berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $heroSlider = HeroSlider::findOrFail($id);

        if ($heroSlider->GambarLatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($heroSlider->GambarLatar)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($heroSlider->GambarLatar);
        }
        if ($heroSlider->GambarBentuk && \Illuminate\Support\Facades\Storage::disk('public')->exists($heroSlider->GambarBentuk)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($heroSlider->GambarBentuk);
        }

        $heroSlider->UserDelete = auth()->user() ? auth()->user()->name : null;
        $heroSlider->save();
        $heroSlider->delete();

        return response()->json(['success' => 'Hero Slider berhasil dihapus!']);
    }
}
