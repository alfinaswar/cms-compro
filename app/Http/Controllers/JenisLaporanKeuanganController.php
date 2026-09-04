<?php

namespace App\Http\Controllers;

use App\Models\JenisLaporanKeuangan;
use App\Models\LaporanKeuanganDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class JenisLaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JenisLaporanKeuangan::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('JumlahDokumen', function ($row) {
                    $count = $row->allDetails()->count();
                    return '<span class="badge badge-info">' . $count . ' Dokumen</span>';
                })
                ->addColumn('IconPreview', function ($row) {
                    return '<span class="badge badge-' . $row->WarnaBadge . '">
                        <i class="fa ' . $row->IconKategori . ' mr-1"></i>' . $row->NamaJenis . '
                    </span>';
                })
                ->addColumn('StatusBadge', function ($row) {
                    $color = $row->Status === 'Aktif' ? 'success' : 'danger';
                    return '<span class="badge badge-' . $color . '">' . $row->Status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';
                    $btn .= '<a href="' . route('jenis-laporan.edit', $row->id) . '" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="' . route('jenis-laporan.details.index', $row->id) . '" class="btn btn-info" title="Kelola Dokumen"><i class="fa fa-file-alt"></i></a>';
                    $btn .= '<button class="btn btn-danger btn-delete" data-id="' . $row->id . '" data-nama="' . $row->NamaJenis . '" title="Hapus"><i class="fa fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['JumlahDokumen', 'IconPreview', 'StatusBadge', 'action'])
                ->make(true);
        }

        return view('master.jenis-laporan.index');
    }

    public function create()
    {
        return view('master.jenis-laporan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NamaJenis' => 'required|string|max:255|unique:jenis_laporan_keuangan,NamaJenis',
            'Deskripsi' => 'nullable|string',
            'IconKategori' => 'required|string|max:50',
            'WarnaBadge' => 'required|in:primary,secondary,success,danger,warning,info',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $validated['Slug'] = Str::slug($validated['NamaJenis']);
        $validated['UserCreate'] = auth()->user()->name;

        JenisLaporanKeuangan::create($validated);

        return redirect()->route('jenis-laporan.index')->with('success', 'Jenis laporan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenis = JenisLaporanKeuangan::findOrFail($id);
        return view('master.jenis-laporan.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $jenis = JenisLaporanKeuangan::findOrFail($id);

        $validated = $request->validate([
            'NamaJenis' => 'required|string|max:255|unique:jenis_laporan_keuangan,NamaJenis,' . $id,
            'Deskripsi' => 'nullable|string',
            'IconKategori' => 'required|string|max:50',
            'WarnaBadge' => 'required|in:primary,secondary,success,danger,warning,info',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $validated['Slug'] = Str::slug($validated['NamaJenis']);
        $validated['UserUpdate'] = auth()->user()->name;

        $jenis->update($validated);

        return redirect()->route('jenis-laporan.index')->with('success', 'Jenis laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenis = JenisLaporanKeuangan::find($id);
        if (!$jenis) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan'], 404);
        }

        $jenis->update(['UserDelete' => auth()->user()->name]);
        $jenis->delete();

        return response()->json(['status' => 200, 'message' => 'Jenis laporan berhasil dihapus']);
    }

    // app/Http/Controllers/FrontendController.php (atau sesuai nama controller Anda)

    public function laporanKeuanganFe()
    {
        // 1. Ambil semua kategori aktif, urutkan berdasarkan 'Urutan'
        $categories = JenisLaporanKeuangan::where('Status', 1)
            ->orderBy('Urutan', 'asc')
            ->with([
                'details' => function ($query) {
                    $query->where('Status', 1)
                        ->orderBy('TahunPeriode', 'desc') // Tahun terbaru di atas
                        ->orderBy('Urutan', 'asc');
                }
            ])
            ->get();

        // 2. Ambil daftar tahun unik untuk filter global (opsional, untuk UX yang lebih baik)
        $availableYears = LaporanKeuanganDetail::where('Status', 1)
            ->select('TahunPeriode')
            ->distinct()
            ->orderBy('TahunPeriode', 'desc')
            ->pluck('TahunPeriode');

        return view('frontend.laporan-keuangan', compact('categories', 'availableYears'));
    }
}
