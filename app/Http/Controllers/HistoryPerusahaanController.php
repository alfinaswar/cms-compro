<?php

namespace App\Http\Controllers;

use App\Models\HistoryPerusahaan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HistoryPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = HistoryPerusahaan::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Tahun', function ($row) {
                    return $row->Tahun ? $row->Tahun : '<span class="text-muted">-</span>';
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
                ->rawColumns(['Tahun', 'Judul', 'Deskripsi'])
                ->make(true);
        }

        return view('pengaturan.landing-page.history-perusahaan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengaturan.landing-page.history-perusahaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Judul' => 'required|string',
            'Tahun' => 'required|integer|min:1900|max:2100',
            'Deskripsi' => 'required|string',
        ]);

        // dd($request->all());
        HistoryPerusahaan::truncate();
        HistoryPerusahaan::create([
            'Tahun' => $request->Tahun,
            'Judul' => $request->Judul,
            'Deskripsi' => $request->Deskripsi,
            'UserCreate' => auth()->check() ? auth()->user()->name : null,
        ]);

        return redirect()->route('history-perusahaan.index')->with('success', 'History Perusahaan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HistoryPerusahaan $historyPerusahaan)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $historyPerusahaan = HistoryPerusahaan::findOrFail($id);
        return view('pengaturan.landing-page.history-perusahaan.edit', compact('historyPerusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Tahun' => 'required|integer',
            'Judul' => 'required|string|max:255',
            'Keterangan' => 'required|string',
        ]);

        $historyPerusahaan = HistoryPerusahaan::findOrFail($id);

        $historyPerusahaan->update([
            'Tahun' => $request->Tahun,
            'Judul' => $request->Judul,
            'Keterangan' => $request->Keterangan,
            'UserUpdate' => auth()->check() ? auth()->user()->name : null,
        ]);

        return redirect()->route('history-perusahaan.index')->with('success', 'History Perusahaan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $historyPerusahaan = HistoryPerusahaan::findOrFail($id);

        $historyPerusahaan->UserDelete = auth()->check() ? auth()->user()->name : null;
        $historyPerusahaan->save();
        $historyPerusahaan->delete();

        return response()->json(['success' => 'History Perusahaan berhasil dihapus!']);
    }
}
