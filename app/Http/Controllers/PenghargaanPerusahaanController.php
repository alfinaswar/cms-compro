<?php

namespace App\Http\Controllers;

use App\Models\PenghargaanPerusahaan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenghargaanPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PenghargaanPerusahaan::latest();
            return DataTables::of($data)
                ->addIndexColumn()
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
                ->addColumn('Action', function ($row) {
                    $id = encrypt($row->id);
                    $urlEdit = route('penghargaan-perusahaan.edit', $id);
                    return '<a href="' . $urlEdit . '" class="btn btn-sm btn-primary mr-1"><i class="fa fa-edit"></i> Detail</a>';
                })
                ->rawColumns(['Judul', 'Deskripsi', 'Action'])
                ->make(true);
        }

        return view('pengaturan.landing-page.penghargaan-perusahaan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengaturan.landing-page.penghargaan-perusahaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'Judul' => 'required|string',
            'Keterangan' => 'required|string',
        ]);

        PenghargaanPerusahaan::truncate();
        PenghargaanPerusahaan::create([
            'Judul' => $request->Judul,
            'Deskripsi' => $request->Keterangan,
            'UserCreate' => auth()->check() ? auth()->user()->name : null,
        ]);

        return redirect()->route('penghargaan-perusahaan.index')->with('success', 'Penghargaan Perusahaan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PenghargaanPerusahaan $penghargaanPerusahaan)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $penghargaanPerusahaan = PenghargaanPerusahaan::with('details')->find($id);
        return view('pengaturan.landing-page.penghargaan-perusahaan.edit', compact('penghargaanPerusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'details' => 'required|array|min:1',
            'details.*.Judul' => 'required|string|max:255',
            'details.*.Deskripsi' => 'required|string',
            'details.*.Gambar' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $penghargaanPerusahaan = PenghargaanPerusahaan::findOrFail($id);
        if (method_exists($penghargaanPerusahaan, 'details')) {
            $penghargaanPerusahaan->details()->delete();
        }

        if ($request->hasFile('details')) {
            foreach ($request->file('details') as $i => $detailFile) {
                $judul = $request->input("details.$i.Judul");
                $deskripsi = $request->input("details.$i.Deskripsi");

                $gambarPath = null;
                if (isset($detailFile['Gambar']) && $detailFile['Gambar']) {
                    $gambarPath = $detailFile['Gambar']->store('penghargaan_perusahaan', 'public');
                }

                $penghargaanPerusahaan->details()->create([
                    'Judul' => $judul,
                    'Deskripsi' => $deskripsi,
                    'Gambar' => $gambarPath,
                    'UserCreate' => auth()->user()->name ?? null,
                ]);
            }
        } else {
            foreach ($request->details as $detail) {
                $penghargaanPerusahaan->details()->create([
                    'Judul' => $detail['Judul'],
                    'Deskripsi' => $detail['Deskripsi'],
                    'Gambar' => null,
                    'UserCreate' => auth()->user()->name ?? null,
                ]);
            }
        }

        return redirect()->route('penghargaan-perusahaan.index')->with('success', 'Detail Penghargaan Perusahaan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penghargaanPerusahaan = PenghargaanPerusahaan::findOrFail($id);

        $penghargaanPerusahaan->UserDelete = auth()->check() ? auth()->user()->name : null;
        $penghargaanPerusahaan->save();
        $penghargaanPerusahaan->delete();

        return response()->json(['success' => 'Penghargaan Perusahaan berhasil dihapus!']);
    }
}
