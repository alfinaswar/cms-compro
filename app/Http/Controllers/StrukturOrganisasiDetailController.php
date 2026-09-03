<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrganisasi;
use App\Models\StrukturOrganisasiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiDetailController extends Controller
{
    /**
     * Tampilkan daftar anggota untuk section tertentu
     */
    public function index(Request $request, $sectionId)
    {
        $section = StrukturOrganisasi::findOrFail($sectionId);

        // Jika permintaan adalah AJAX (dari DataTables)
        if ($request->ajax()) {
            $query = $section->allDetails();

            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('PathFoto', function ($row) {
                    if ($row->PathFoto) {
                        return '<img src="' . asset('storage/' . $row->PathFoto) . '" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">';
                    } else {
                        return '<span class="badge badge-light text-muted" style="font-size: 10px;">No Photo</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';

                    // Tombol Edit
                    $btn .= '<a href="' . route('struktur-organisasi.anggota.edit', [$row->StrukturOrganisasiId, $row->id]) . '" class="btn btn-warning btn-sm" title="Edit">';
                    $btn .= '<i class="fa fa-edit"></i></a> ';

                    // Tombol Delete (Pastikan ada data-url dan data-nama)
                    $btn .= '<button type="button" class="btn btn-danger btn-sm btn-delete-confirm"
                     data-url="' . route('struktur-organisasi.anggota.destroy', [$row->StrukturOrganisasiId, $row->id]) . '"
                     data-nama="' . $row->NamaLengkap . '"
                     title="Hapus">';
                    $btn .= '<i class="fa fa-trash"></i></button>';

                    $btn .= '</div>';
                    return $btn;
                })
                ->editColumn('Status', function ($row) {
                    if ($row->Status == 'Aktif') {
                        return '<span class="badge badge-success">Aktif</span>';
                    }
                    return '<span class="badge badge-danger">Nonaktif</span>';
                })
                ->rawColumns(['PathFoto', 'action', 'Status'])
                ->make(true);
        }

        // Bukan AJAX, render view biasa
        return view('pages.struktur-organisasi.anggota.index', compact('section'));
    }

    public function create($sectionId)
    {
        $section = StrukturOrganisasi::findOrFail($sectionId);
        return view('pages.struktur-organisasi.anggota.create', compact('section'));
    }

    public function store(Request $request, $sectionId)
    {
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Jabatan' => 'required|string|max:255',
            'DeskripsiSingkat' => 'nullable|string',
            'PathFoto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $data = $request->except('_token');
        $data['StrukturOrganisasiId'] = $sectionId;
        $data['UserCreate'] = auth()->user()->name;

        if ($request->hasFile('PathFoto')) {
            $data['PathFoto'] = $request->file('PathFoto')->store('struktur/foto', 'public');
        }

        StrukturOrganisasiDetail::create($data);

        return redirect()->route('struktur-organisasi.anggota.index', $sectionId)
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit($sectionId, $id)
    {
        $section = StrukturOrganisasi::findOrFail($sectionId);
        $anggota = StrukturOrganisasiDetail::findOrFail($id);

        return view('pages.struktur-organisasi.anggota.edit', compact('section', 'anggota'));
    }

    public function update(Request $request, $sectionId, $id)
    {
        $anggota = StrukturOrganisasiDetail::findOrFail($id);

        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Jabatan' => 'required|string|max:255',
            'DeskripsiSingkat' => 'nullable|string',
            'PathFoto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $data = $request->except('_token');
        $data['UserUpdate'] = auth()->user()->name;

        if ($request->hasFile('PathFoto')) {
            if ($anggota->PathFoto && Storage::disk('public')->exists($anggota->PathFoto)) {
                Storage::disk('public')->delete($anggota->PathFoto);
            }
            $data['PathFoto'] = $request->file('PathFoto')->store('struktur/foto', 'public');
        }

        $anggota->update($data);

        return redirect()->route('pages.struktur-organisasi.anggota.index', $sectionId)
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy($sectionId, $id)
    {
        $anggota = StrukturOrganisasiDetail::find($id);

        if (!$anggota) {
            return response()->json([
                'message' => 'Anggota tidak ditemukan.'
            ], 404);
        }
        $anggota->update([
            'UserDelete' => auth()->user()->name
        ]);
        $anggota->delete();
        return response()->json([
            'message' => 'Anggota berhasil dihapus.'
        ]);
    }
}
