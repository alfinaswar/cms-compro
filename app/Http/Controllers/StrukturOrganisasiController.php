<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrganisasi;
use App\Models\StrukturOrganisasiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource (Admin - Nested DataTables)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StrukturOrganisasi::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('GambarHeader', function ($row) {
                    if ($row->PathGambarHeader) {
                        return '<img src="' . Storage::url($row->PathGambarHeader) . '" style="width:80px;height:40px;object-fit:cover;border-radius:4px;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('JumlahAnggota', function ($row) {
                    $count = $row->allDetails()->where('Status', 'Aktif')->count();
                    return '<span class="badge badge-info">' . $count . ' Orang</span>';
                })
                ->addColumn('StatusBadge', function ($row) {
                    $color = $row->Status === 'Aktif' ? 'success' : 'danger';
                    return '<span class="badge badge-' . $color . '">' . $row->Status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';
                    $btn .= '<a href="' . route('struktur-organisasi.edit', $row->id) . '" class="btn btn-warning" title="Edit Section"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="' . route('struktur-organisasi.anggota.index', $row->id) . '" class="btn btn-info btn-detail" data-id="' . $row->id . '" title="Kelola Anggota"><i class="fa fa-users"></i></a>';
                    $btn .= '<button class="btn btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus Section"><i class="fa fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['GambarHeader', 'JumlahAnggota', 'StatusBadge', 'action'])
                ->make(true);
        }

        return view('pages.admin.struktur-organisasi.index');
    }

    public function create()
    {
        return view('pages.admin.struktur-organisasi.create');
    }

    public function store(Request $request)
    {
        // Truncate table sebelum input baru
        DB::table('struktur_organisasis')->truncate();

        $validated = $request->validate([
            'JudulSection' => 'required|string|max:255',
            'DeskripsiSection' => 'nullable|string',
            'PathGambarHeader' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('PathGambarHeader')) {
            $validated['PathGambarHeader'] = $request->file('PathGambarHeader')->store('struktur/header', 'public');
        }

        $validated['UserCreate'] = auth()->user()->name;

        StrukturOrganisasi::create($validated);

        return redirect()->route('struktur-organisasi.index')->with('success', 'Section Struktur Organisasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $section = StrukturOrganisasi::findOrFail($id);
        return view('pages.admin.struktur-organisasi.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {
        // Truncate table sebelum input baru
        DB::table('struktur_organisasis')->truncate();

        $section = StrukturOrganisasi::findOrFail($id);

        $validated = $request->validate([
            'JudulSection' => 'required|string|max:255',
            'DeskripsiSection' => 'nullable|string',
            'PathGambarHeader' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('PathGambarHeader')) {
            if ($section->PathGambarHeader && Storage::disk('public')->exists($section->PathGambarHeader)) {
                Storage::disk('public')->delete($section->PathGambarHeader);
            }
            $validated['PathGambarHeader'] = $request->file('PathGambarHeader')->store('struktur/header', 'public');
        }

        $validated['UserUpdate'] = auth()->user()->name;

        $section->update($validated);

        return redirect()->route('struktur-organisasi.index')->with('success', 'Section berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $section = StrukturOrganisasi::find($id);
        if (!$section) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus file header
        if ($section->PathGambarHeader && Storage::disk('public')->exists($section->PathGambarHeader)) {
            Storage::disk('public')->delete($section->PathGambarHeader);
        }

        $section->update(['UserDelete' => auth()->user()->name]);
        $section->delete();

        return response()->json(['status' => 200, 'message' => 'Section berhasil dihapus']);
    }

    // ========== AJAX: MANAGE DETAILS (ANGGOTA) ==========

    // Get details for a section (AJAX for modal)
    public function getDetails($sectionId)
    {
        $details = StrukturOrganisasiDetail::where('StrukturOrganisasiId', $sectionId)
            ->orderBy('Urutan')
            ->get();
        return response()->json($details);
    }

    // Store new detail/person (AJAX)
    public function storeDetail(Request $request)
    {
        // Truncate table sebelum input baru
        DB::table('struktur_organisasi_details')->truncate();

        $validated = $request->validate([
            'StrukturOrganisasiId' => 'required|exists:struktur_organisasis,id',
            'NamaLengkap' => 'required|string|max:255',
            'Jabatan' => 'required|string|max:255',
            'DeskripsiSingkat' => 'nullable|string',
            'PathFoto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('PathFoto')) {
            $validated['PathFoto'] = $request->file('PathFoto')->store('struktur/foto', 'public');
        }

        $validated['UserCreate'] = auth()->user()->name;

        $detail = StrukturOrganisasiDetail::create($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Anggota berhasil ditambahkan',
            'data' => $detail
        ]);
    }

    // Update detail/person (AJAX)
    public function updateDetail(Request $request, $id)
    {
        // Truncate table sebelum input baru
        DB::table('struktur_organisasi_details')->truncate();

        $detail = StrukturOrganisasiDetail::findOrFail($id);

        $validated = $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Jabatan' => 'required|string|max:255',
            'DeskripsiSingkat' => 'nullable|string',
            'PathFoto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('PathFoto')) {
            if ($detail->PathFoto && Storage::disk('public')->exists($detail->PathFoto)) {
                Storage::disk('public')->delete($detail->PathFoto);
            }
            $validated['PathFoto'] = $request->file('PathFoto')->store('struktur/foto', 'public');
        }

        $validated['UserUpdate'] = auth()->user()->name;

        $detail->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Data anggota berhasil diperbarui'
        ]);
    }

    // Delete detail/person (AJAX)
    public function destroyDetail($id)
    {
        $detail = StrukturOrganisasiDetail::find($id);
        if (!$detail) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        if ($detail->PathFoto && Storage::disk('public')->exists($detail->PathFoto)) {
            Storage::disk('public')->delete($detail->PathFoto);
        }

        $detail->update(['UserDelete' => auth()->user()->name]);
        $detail->delete();

        return response()->json(['status' => 200, 'message' => 'Anggota berhasil dihapus']);
    }
}
