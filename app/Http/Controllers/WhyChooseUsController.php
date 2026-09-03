<?php
namespace App\Http\Controllers;

use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class WhyChooseUsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WhyChooseUs::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->Status
                        ? '<span class="badge badge-success px-2 py-1">Aktif</span>'
                        : '<span class="badge badge-secondary px-2 py-1">Tidak Aktif</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="btn-group btn-group-sm">
                            <a href="' . route('why-choose-us.edit', $row->id) . '" class="btn btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->addColumn('Icon', function ($row) {
                    if ($row->Icon) {
                        $url = asset('storage/' . $row->Icon);
                        return '<img src="' . $url . '" alt="Icon" style="height:40px;">';
                    } else {
                        return '<span class="text-muted">-</span>';
                    }
                })

                ->rawColumns(['status', 'action','Icon'])
                ->make(true);
        }

        return view('pages.admin.why-choose-us.index');
    }

    public function create()
    {
        return view('pages.admin.why-choose-us.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Icon' => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048', // Maksimal 2MB
            'Judul' => 'required|string|max:255',
            'Deskripsi' => 'required|string',
            'Urutan' => 'required|integer|min:0',
            'Status' => 'required|boolean',
        ]);

        $iconPath = null;
        if ($request->hasFile('Icon')) {
            $iconPath = $request->file('Icon')->store('why-choose-us/icons', 'public');
        }

        WhyChooseUs::create([
            'Icon' => $iconPath,
            'Judul' => $request->Judul,
            'Deskripsi' => $request->Deskripsi,
            'Urutan' => $request->Urutan,
            'Status' => $request->Status,
        ]);

        return redirect()->route('why-choose-us.index')->with('success', 'Data keunggulan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = WhyChooseUs::findOrFail($id);
        return view('pages.admin.why-choose-us.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Icon' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'Judul' => 'required|string|max:255',
            'Deskripsi' => 'required|string',
            'Urutan' => 'required|integer|min:0',
            'Status' => 'required|boolean',
        ]);

        $item = WhyChooseUs::findOrFail($id);
        $iconPath = $item->Icon;

        // Hapus file lama jika ada file baru yang diupload
        if ($request->hasFile('Icon')) {
            if ($iconPath && Storage::disk('public')->exists($iconPath)) {
                Storage::disk('public')->delete($iconPath);
            }
            $iconPath = $request->file('Icon')->store('why-choose-us/icons', 'public');
        }

        $item->update([
            'Icon' => $iconPath,
            'Judul' => $request->Judul,
            'Deskripsi' => $request->Deskripsi,
            'Urutan' => $request->Urutan,
            'Status' => $request->Status,
        ]);

        return redirect()->route('why-choose-us.index')->with('success', 'Data keunggulan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $item = WhyChooseUs::findOrFail($id);

            // Hapus file icon dari storage
            if ($item->Icon && Storage::disk('public')->exists($item->Icon)) {
                Storage::disk('public')->delete($item->Icon);
            }

            $item->delete();
            return response()->json(['message' => 'Data berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data.'], 500);
        }
    }
}
