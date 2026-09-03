<?php

namespace App\Http\Controllers;

use App\Models\KeyFigures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class KeyFiguresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KeyFigures::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $encryptedId = encrypt($row->id);
                    return '
                        <div class="btn-group btn-group-sm">
                            <a href="' . route('pengaturan-key-figure.edit', $encryptedId) . '" class="btn btn-warning btn-edit" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->addColumn('Icon', function ($row) {
                    if ($row->Icon) {
                        $url = asset('storage/' . $row->Icon);
                        return '<img src="' . $url . '" alt="Icon" style="height:40px;max-width:60px;object-fit:contain;">';
                    } else {
                        return '<span class="text-muted">-</span>';
                    }
                })
                ->rawColumns(['action', 'Icon'])
                ->make(true);
        }

        return view('pengaturan.landing-page.key-figure.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengaturan.landing-page.key-figure.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'Konten' => 'required|string|max:255',
            'Keterangan' => 'required|string',
            'Icon' => 'nullable|file|image|max:1024',
        ]);

        $iconPath = null;
        if ($request->hasFile('Icon')) {
            $iconPath = $request->file('Icon')->store('key-figures/icons', 'public');
        }

        $data = [
            'Konten' => $request->Konten,
            'Keterangan' => $request->Keterangan,
            'Icon' => $iconPath,
            'UserCreate' => auth()->user() ? auth()->user()->name : null,
        ];

        KeyFigures::create($data);

        return redirect()->route('pengaturan-key-figure.index')->with('success', 'Key Figure created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KeyFigures $keyFigures)
    {
        //
    }

    /** Show the form for editing the specified resource. */

    /**
     * Decrypt the specified Key Figure and show the edit form.
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $keyFigure = KeyFigures::findOrFail($id);
        return view('pengaturan.landing-page.key-figure.edit', compact('keyFigure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Konten' => 'required|string|max:255',
            'Keterangan' => 'required|string',
            'Icon' => 'nullable|file|image|max:1024',
        ]);

        $data = KeyFigures::findOrFail($id);

        $iconPath = $data->Icon;

        if ($request->hasFile('Icon')) {
            if ($iconPath && Storage::disk('public')->exists($iconPath)) {
                Storage::disk('public')->delete($iconPath);
            }
            $iconPath = $request->file('Icon')->store('key-figures/icons', 'public');
        }

        $data->update([
            'Konten' => $request->Konten,
            'Keterangan' => $request->Keterangan,
            'Icon' => $iconPath,
            'UserUpdate' => auth()->user() ? auth()->user()->name : null,
        ]);

        return redirect()->route('pengaturan-key-figure.index')->with('success', 'Key Figure updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $keyFigure = KeyFigures::findOrFail($id);

            // Hapus icon jika ada
            if ($keyFigure->Icon && Storage::disk('public')->exists($keyFigure->Icon)) {
                Storage::disk('public')->delete($keyFigure->Icon);
            }

            $keyFigure->delete();

            return response()->json([
                'message' => 'Key Figure berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus Key Figure. ' . $e->getMessage()
            ], 500);
        }
    }
}
