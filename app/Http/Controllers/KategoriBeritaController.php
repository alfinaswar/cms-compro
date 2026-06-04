<?php
namespace App\Http\Controllers;

use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class KategoriBeritaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriBerita::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-warning btn-edit" data-id="' . $row->id . '" data-nama="' . $row->NamaKategori . '" title="Edit"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus"><i class="fa fa-trash"></i></button>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.admin.master.kategori-berita.index');
    }

    // Endpoint untuk AJAX on-the-fly & standar form
    // Store method
    public function store(Request $request)
    {
        $request->validate([
            'NamaKategori' => 'required'
        ]);

        $kategori = KategoriBerita::create([
            'NamaKategori' => $request->NamaKategori,
            'Slug' => Str::slug($request->NamaKategori),
            'UserCreate' => auth()->user()->name,
        ]);

        // Return JSON untuk AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 200,
                'message' => 'Kategori berhasil ditambahkan',
                'data' => $kategori
            ]);
        }

        return redirect()->route('kategori-berita.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    // Update method
    public function update(Request $request, $id)
    {
        $kategori = KategoriBerita::findOrFail($id);

        $request->validate([
            'NamaKategori' => 'required|string|max:100|unique:kategori_berita,NamaKategori,' . $id
        ]);

        $kategori->update([
            'NamaKategori' => $request->NamaKategori,
            'Slug' => Str::slug($request->NamaKategori),
            'UserUpdate' => auth()->user()->name,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Kategori berhasil diperbarui'
        ]);
    }

    // Destroy method
    public function destroy($id)
    {
        $kategori = KategoriBerita::find($id);
        if (!$kategori) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        $kategori->update(['UserDelete' => auth()->user()->name]);
        $kategori->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }

    // Endpoint khusus untuk mengambil list kategori (JSON)
    public function apiKategori()
    {
        $kategoris = KategoriBerita::whereNull('deleted_at')->orderBy('NamaKategori')->get();
        return response()->json($kategoris);
    }
}
