<?php

namespace App\Http\Controllers;

use App\Models\MasterProduk;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MasterProdukController extends Controller
{
    public function __construct()
    {
        // Opsional permission jika menggunakan role/permission
        $this->middleware('permission:pengaturan-form-kontak.view')->only(['index']);
        $this->middleware('permission:pengaturan-form-kontak.create')->only(['create', 'store']);
        $this->middleware('permission:pengaturan-form-kontak.edit')->only(['edit', 'update']);
        $this->middleware('permission:pengaturan-form-kontak.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterProduk::with('parent.parent')->orderBy('parent_id', 'asc')->orderBy('Urutan', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('KategoriInduk', function ($row) {
                    $parts = [];
                    $p = $row->parent;
                    while ($p) {
                        array_unshift($parts, $p->Nama);
                        $p = $p->parent;
                    }
                    return empty($parts) ? '<span class="badge badge-primary">Kategori Utama</span>' : implode(' &gt; ', $parts);
                })
                ->addColumn('Status', function ($row) {
                    return $row->StatusAktif
                        ? '<span class="badge badge-success">Aktif</span>'
                        : '<span class="badge badge-secondary">Nonaktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';

                    $btn .= '<button type="button" '
                        . 'class="btn btn-warning btn-edit" '
                        . 'data-id="' . $row->id . '" '
                        . 'data-nama="' . e($row->Nama) . '" '
                        . 'data-namatranslate="' . e($row->NamaTranslate ?? '') . '" '
                        . 'data-parent_id="' . ($row->parent_id ?? '') . '" '
                        . 'data-urutan="' . $row->Urutan . '" '
                        . 'data-status="' . ($row->StatusAktif ? 1 : 0) . '" '
                        . 'title="Edit">'
                        . '<i class="fa fa-edit"></i>'
                        . '</button>';

                    $btn .= '<button type="button" '
                        . 'class="btn btn-danger btn-delete" '
                        . 'data-id="' . $row->id . '" '
                        . 'data-nama="' . e($row->Nama) . '" '
                        . 'title="Hapus">'
                        . '<i class="fa fa-trash"></i>'
                        . '</button>';

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['KategoriInduk', 'Status', 'action'])
                ->make(true);
        }

        $allParents = MasterProduk::whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->with('children');
            }])
            ->orderBy('Urutan', 'asc')
            ->get();

        return view('pages.admin.master-produk.index', compact('allParents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nama' => 'required|string|max:255',
            'NamaTranslate' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:master_produks,id',
            'Urutan' => 'nullable|integer',
            'StatusAktif' => 'nullable|boolean',
        ]);

        $validated['StatusAktif'] = $request->has('StatusAktif') ? (bool) $request->StatusAktif : true;
        $validated['Urutan'] = $request->filled('Urutan') ? (int) $request->Urutan : 0;
        $validated['UserCreate'] = auth()->user() ? auth()->user()->name : 'system';

        MasterProduk::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 200,
                'message' => 'Produk/Layanan berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('master-produk.index')->with('success', 'Produk/Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = MasterProduk::findOrFail($id);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 200,
                'data' => [
                    'id' => $produk->id,
                    'Nama' => $produk->Nama,
                    'NamaTranslate' => $produk->NamaTranslate,
                    'parent_id' => $produk->parent_id,
                    'Urutan' => $produk->Urutan,
                    'StatusAktif' => $produk->StatusAktif ? 1 : 0,
                ],
            ]);
        }

        return redirect()->route('master-produk.index');
    }

    public function update(Request $request, $id)
    {
        $produk = MasterProduk::findOrFail($id);

        $validated = $request->validate([
            'Nama' => 'required|string|max:255',
            'NamaTranslate' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:master_produks,id|not_in:' . $id,
            'Urutan' => 'nullable|integer',
            'StatusAktif' => 'nullable|boolean',
        ]);

        $validated['StatusAktif'] = $request->has('StatusAktif') ? (bool) $request->StatusAktif : true;
        $validated['Urutan'] = $request->filled('Urutan') ? (int) $request->Urutan : 0;
        $validated['UserUpdate'] = auth()->user() ? auth()->user()->name : 'system';

        $produk->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 200,
                'message' => 'Produk/Layanan berhasil diperbarui.',
            ]);
        }

        return redirect()->route('master-produk.index')->with('success', 'Produk/Layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = MasterProduk::find($id);
        if (!$produk) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        $produk->update(['UserDelete' => auth()->user() ? auth()->user()->name : 'system']);
        $produk->delete();

        return response()->json(['status' => 200, 'message' => 'Produk/Layanan berhasil dihapus']);
    }
}
