<?php

namespace App\Http\Controllers;

use App\Models\ValuePerusahaan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ValuePerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ValuePerusahaan::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Judul', function ($row) {
                    return $row->Judul ?: '<span class="text-muted">-</span>';
                })
                ->addColumn('Keterangan', function ($row) {
                    if ($row->Keterangan) {
                        $plainText = strip_tags($row->Keterangan);
                        if (mb_strlen($plainText) > 100) {
                            return mb_substr($plainText, 0, 100) . '...';
                        }
                        return $plainText;
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->addColumn('action', function ($row) {
                    $encryptedId = encrypt($row->id);
                    $btn = '<div class="btn-group btn-group-sm">';
                    $btn .= '<a href="' . route('value-perusahaan.edit', $encryptedId) . '" class="btn btn-warning btn-edit" title="Edit"><i class="fa fa-edit"></i></a>';
                    $btn .= '<button class="btn btn-danger btn-delete" data-id="' . $encryptedId . '" title="Hapus"><i class="fa fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['Judul', 'Keterangan', 'action'])
                ->make(true);
        }
        return view('pengaturan.landing-page.value-perusahaan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengaturan.landing-page.value-perusahaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Judul' => 'required|string',
            'Keterangan' => 'required|string',
        ]);

        ValuePerusahaan::truncate();
        ValuePerusahaan::create([
            'Judul' => $request->Judul,
            'Keterangan' => $request->Keterangan,
            'UserCreate' => auth()->check() ? auth()->user()->name : null,
        ]);

        return redirect()->route('value-perusahaan.index')->with('success', 'Value Perusahaan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ValuePerusahaan $valuePerusahaan)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $valuePerusahaan = ValuePerusahaan::findOrFail($id);
        return view('pengaturan.landing-page.value-perusahaan.edit', compact('valuePerusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Judul' => 'required|string',
            'Keterangan' => 'required|string',
        ]);

        $valuePerusahaan = ValuePerusahaan::findOrFail($id);

        $valuePerusahaan->update([
            'Judul' => $request->Judul,
            'Keterangan' => $request->Keterangan,
            'UserUpdate' => auth()->check() ? auth()->user()->name : null,
        ]);

        return redirect()->route('value-perusahaan.index')->with('success', 'Value Perusahaan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        $valuePerusahaan = ValuePerusahaan::findOrFail($id);
        $valuePerusahaan->delete();

        return response()->json(['success' => true, 'message' => 'Value Perusahaan berhasil dihapus.']);
    }
}
