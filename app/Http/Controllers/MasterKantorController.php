<?php

namespace App\Http\Controllers;

use App\Models\MasterKantor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MasterKantorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterKantor::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('TipeBadge', function ($row) {
                    $color = $row->TipeKantor === 'Pusat' ? 'primary' : 'info';
                    $icon = $row->TipeKantor === 'Pusat' ? 'fa-building' : 'fa-store';
                    return '<span class="badge badge-' . $color . '"><i class="fa ' . $icon . ' mr-1"></i>' . $row->TipeKantor . '</span>';
                })
                ->addColumn('KontakInfo', function ($row) {
                    $html = '';
                    if ($row->NomorTelepon)
                        $html .= '<div><i class="fa fa-phone text-muted mr-1"></i> ' . $row->NomorTelepon . '</div>';
                    if ($row->AlamatEmail)
                        $html .= '<div><i class="fa fa-envelope text-muted mr-1"></i> ' . $row->AlamatEmail . '</div>';
                    return $html ?: '<span class="text-muted">-</span>';
                })
                ->addColumn('StatusBadge', function ($row) {
                    $color = $row->Status === 'Aktif' ? 'success' : 'danger';
                    return '<span class="badge badge-' . $color . '">' . $row->Status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';
                    $btn .= '<a href="' . route('master-kantor.edit', $row->id) . '" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>';
                    $btn .= '<button class="btn btn-danger btn-delete" data-id="' . $row->id . '" data-nama="' . $row->NamaKantor . '" title="Hapus"><i class="fa fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['TipeBadge', 'KontakInfo', 'StatusBadge', 'action'])
                ->make(true);
        }

        return view('master.kantor.index');
    }

    public function create()
    {
        return view('master.kantor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NamaKantor' => 'required|string|max:255',
            'TipeKantor' => 'required|in:Pusat,Cabang',
            'AlamatLengkap' => 'required|string',
            'Kota' => 'required|string|max:100',
            'Provinsi' => 'required|string|max:100',
            'KodePos' => 'nullable|string|max:20',
            'TautanGoogleMaps' => 'nullable|url|max:255',
            'EmbedGoogleMaps' => 'nullable|string',
            'NomorTelepon' => 'nullable|string|max:50',
            'NomorWhatsApp' => 'nullable|string|max:50',
            'AlamatEmail' => 'nullable|email|max:255',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $validated['UserCreate'] = auth()->user()->name;
        MasterKantor::create($validated);

        return redirect()->route('master-kantor.index')->with('success', 'Data kantor berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kantor = MasterKantor::findOrFail($id);
        return view('master.kantor.edit', compact('kantor'));
    }

    public function update(Request $request, $id)
    {
        $kantor = MasterKantor::findOrFail($id);

        $validated = $request->validate([
            'NamaKantor' => 'required|string|max:255',
            'TipeKantor' => 'required|in:Pusat,Cabang',
            'AlamatLengkap' => 'required|string',
            'Kota' => 'required|string|max:100',
            'Provinsi' => 'required|string|max:100',
            'KodePos' => 'nullable|string|max:20',
            'TautanGoogleMaps' => 'nullable|url|max:255',
            'EmbedGoogleMaps' => 'nullable|string',
            'NomorTelepon' => 'nullable|string|max:50',
            'NomorWhatsApp' => 'nullable|string|max:50',
            'AlamatEmail' => 'nullable|email|max:255',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $validated['UserUpdate'] = auth()->user()->name;
        $kantor->update($validated);

        return redirect()->route('master-kantor.index')->with('success', 'Data kantor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kantor = MasterKantor::find($id);
        if (!$kantor) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        $kantor->update(['UserDelete' => auth()->user()->name]);
        $kantor->delete();

        return response()->json(['status' => 200, 'message' => 'Data kantor berhasil dihapus']);
    }
}
