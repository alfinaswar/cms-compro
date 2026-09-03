<?php

namespace App\Http\Controllers;

use App\Models\ClientLogo;
use App\Models\ClientLogoDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ClientLogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ClientLogo::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('PreviewLogo', function ($row) {
                    if ($row->PathLogo) {
                        return '<img src="' . Storage::url($row->PathLogo) . '" style="width:80px;height:50px;object-fit:contain;border:1px solid #ddd;border-radius:4px;background:#fff;">';
                    }
                    return '<span class="text-muted">No Logo</span>';
                })
                ->addColumn('TipeBadge', function ($row) {
                    $color = $row->Tipe === 'Partner' ? 'info' : 'warning';
                    $icon = $row->Tipe === 'Partner' ? 'fa-handshake' : 'fa-certificate';
                    return '<span class="badge badge-' . $color . '"><i class="fa ' . $icon . ' mr-1"></i>' . $row->Tipe . '</span>';
                })
                ->addColumn('StatusBadge', function ($row) {
                    $color = $row->Status === 'Aktif' ? 'success' : 'danger';
                    return '<span class="badge badge-' . $color . '">' . $row->Status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';
                    $btn .= '<a href="' . route('client-logo.edit', $row->id) . '" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>';
                    // Jika tipe Sertifikasi, tampilkan tombol Add Detail DAN Show
                    if ($row->Tipe === 'Sertifikasi') {
                        $btn .= '<a href="' . route('client-logo.show', $row->id) . '" class="btn btn-primary" title="Lihat Detail"><i class="fa fa-eye"></i> Show</a>';
                    }
                    $btn .= '<button class="btn btn-danger btn-delete" data-id="' . $row->id . '" data-nama="' . $row->NamaPartner . '" title="Hapus"><i class="fa fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })


                ->rawColumns(['PreviewLogo', 'TipeBadge', 'StatusBadge', 'action'])
                ->make(true);
        }

        return view('pages.admin.client-logo.index');
    }

    public function create()
    {
        return view('pages.admin.client-logo.create');
    }
    public function createDetail($idClient)
    {
        return view('pages.admin.client-logo.create-detail', compact('idClient'));
    }
    public function show($id)
    {
        $parent = ClientLogo::findOrFail($id);
        $details = ClientLogoDetail::where('IdClientLogo', $id)
            ->orderBy('Urutan')
            ->get();

        return view('pages.admin.client-logo.show', compact('parent', 'details'));

    }
    public function storeDetail(Request $request,$id)
    {
        // dd($id);
        $validated = $request->validate([
            'SubJudul' => 'nullable|string|max:255',
            'Judul' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
            'PathGambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'UrlWebsite' => 'nullable|url|max:255',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('PathGambar')) {
            $validated['PathGambar'] = $request->file('PathGambar')->store('client-logos/details', 'public');
        }

        $validated['IdClientLogo'] = $id;
        $validated['UserCreate'] = auth()->user()->name;

        ClientLogoDetail::create($validated);

        return redirect()->back()->with('success', 'Detail berhasil ditambahkan.');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'NamaPartner' => 'required|string|max:255',
            'PathLogo' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'UrlWebsite' => 'nullable|url|max:255',
            'Tipe' => 'required|in:Partner,Sertifikasi',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        // Handle Upload Logo
        if ($request->hasFile('PathLogo')) {
            $validated['PathLogo'] = $request->file('PathLogo')->store('client-logos', 'public');
        }

        $validated['UserCreate'] = auth()->user()->name;

        ClientLogo::create($validated);

        return redirect()->route('client-logo.index')->with('success', 'Logo berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $logo = ClientLogo::findOrFail($id);
        return view('pages.admin.client-logo.edit', compact('logo'));
    }

    public function update(Request $request, $id)
    {
        $logo = ClientLogo::findOrFail($id);

        $validated = $request->validate([
            'NamaPartner' => 'required|string|max:255',
            'PathLogo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'UrlWebsite' => 'nullable|url|max:255',
            'Tipe' => 'required|in:Partner,Sertifikasi',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        // Handle Upload Logo Baru
        if ($request->hasFile('PathLogo')) {
            if ($logo->PathLogo && Storage::disk('public')->exists($logo->PathLogo)) {
                Storage::disk('public')->delete($logo->PathLogo);
            }
            $validated['PathLogo'] = $request->file('PathLogo')->store('client-logos', 'public');
        }

        $validated['UserUpdate'] = auth()->user()->name;

        $logo->update($validated);

        return redirect()->route('client-logo.index')->with('success', 'Logo berhasil diperbarui.');
    }
    public function updateDetail(Request $request, $id)
    {
        $detail = ClientLogoDetail::findOrFail($id);

        $validated = $request->validate([
            'SubJudul' => 'nullable|string|max:255',
            'Judul' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
            'PathGambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'UrlWebsite' => 'nullable|url|max:255',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('PathGambar')) {
            if ($detail->PathGambar && Storage::disk('public')->exists($detail->PathGambar)) {
                Storage::disk('public')->delete($detail->PathGambar);
            }
            $validated['PathGambar'] = $request->file('PathGambar')->store('client-logos/details', 'public');
        }

        $validated['UserUpdate'] = auth()->user()->name;
        $detail->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Detail berhasil diperbarui'
        ]);
    }
    public function destroy($id)
    {
        $logo = ClientLogo::find($id);
        if (!$logo) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus file logo fisik
        if ($logo->PathLogo && Storage::disk('public')->exists($logo->PathLogo)) {
            Storage::disk('public')->delete($logo->PathLogo);
        }

        $logo->update(['UserDelete' => auth()->user()->name]);
        $logo->delete(); // Soft delete

        return response()->json(['status' => 200, 'message' => 'Logo berhasil dihapus']);
    }
}
