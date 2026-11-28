<?php

namespace App\Http\Controllers;

use App\Models\NewsBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class NewsBannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:berita.view')->only(['index']);
        $this->middleware('permission:berita.create')->only(['store']);
        $this->middleware('permission:berita.edit')->only(['update']);
        $this->middleware('permission:berita.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = NewsBanner::orderBy('Urutan')->latest('id');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Preview', function ($row) {
                    if ($row->ImagePath && Storage::disk('public')->exists($row->ImagePath)) {
                        return '<img src="' . asset('storage/' . $row->ImagePath) . '" alt="' . e($row->Title ?: 'Banner') . '" class="rounded shadow-sm" style="height:60px; max-width:100px; object-fit:cover;">';
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->addColumn('LinkDisplay', function ($row) {
                    if (!$row->LinkUrl) {
                        return '<span class="text-muted">-</span>';
                    }
                    return '<a href="' . e($row->LinkUrl) . '" target="_blank" rel="noopener noreferrer" class="text-primary">' . e(\Illuminate\Support\Str::limit($row->LinkUrl, 45)) . ' <i class="fa fa-external-link-alt ml-1" style="font-size:11px;"></i></a>';
                })
                ->addColumn('StatusBadge', function ($row) {
                    return $row->IsActive
                        ? '<span class="badge badge-success">Aktif</span>'
                        : '<span class="badge badge-secondary">Nonaktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';
                    if (auth()->user()->can('berita.edit')) {
                        $btn .= '<button class="btn btn-warning btn-edit" '
                            . 'data-id="' . $row->id . '" '
                            . 'data-title="' . e($row->Title ?? '') . '" '
                            . 'data-link="' . e($row->LinkUrl ?? '') . '" '
                            . 'data-urutan="' . (int) $row->Urutan . '" '
                            . 'data-active="' . ($row->IsActive ? 1 : 0) . '" '
                            . 'data-image="' . ($row->ImagePath ? asset('storage/' . $row->ImagePath) : '') . '" '
                            . 'title="Edit"><i class="fa fa-edit"></i></button>';
                    }
                    if (auth()->user()->can('berita.delete')) {
                        $btn .= '<button class="btn btn-danger btn-delete" data-id="' . $row->id . '" data-title="' . e($row->Title ?: 'Banner #' . $row->id) . '" title="Hapus"><i class="fa fa-trash"></i></button>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['Preview', 'LinkDisplay', 'StatusBadge', 'action'])
                ->make(true);
        }

        $nextUrutan = (NewsBanner::max('Urutan') ?? 0) + 1;

        return view('pages.admin.berita.banner.index', compact('nextUrutan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Title' => 'nullable|string|max:255',
            'ImagePath' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'LinkUrl' => 'nullable|url|max:500',
            'Urutan' => 'nullable|integer|min:1',
            'IsActive' => 'nullable|boolean',
        ], [
            'ImagePath.required' => 'Gambar banner wajib diunggah.',
            'ImagePath.image' => 'File harus berupa gambar.',
            'LinkUrl.url' => 'Format URL link tidak valid (sertakan https://).',
        ]);

        $imagePath = $request->file('ImagePath')->store('berita/banner', 'public');

        $banner = NewsBanner::create([
            'Title' => $validated['Title'] ?? null,
            'ImagePath' => $imagePath,
            'LinkUrl' => $validated['LinkUrl'] ?? null,
            'Urutan' => $validated['Urutan'] ?? ((NewsBanner::max('Urutan') ?? 0) + 1),
            'IsActive' => $request->boolean('IsActive'),
            'UserCreate' => auth()->user()?->name,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Banner berhasil ditambahkan.',
            'data' => $banner,
        ]);
    }

    public function update(Request $request, $id)
    {
        $banner = NewsBanner::findOrFail($id);

        $validated = $request->validate([
            'Title' => 'nullable|string|max:255',
            'ImagePath' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'LinkUrl' => 'nullable|url|max:500',
            'Urutan' => 'nullable|integer|min:1',
            'IsActive' => 'nullable|boolean',
        ], [
            'ImagePath.image' => 'File harus berupa gambar.',
            'LinkUrl.url' => 'Format URL link tidak valid (sertakan https://).',
        ]);

        $imagePath = $banner->ImagePath;
        if ($request->hasFile('ImagePath')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('ImagePath')->store('berita/banner', 'public');
        }

        $banner->update([
            'Title' => $validated['Title'] ?? null,
            'ImagePath' => $imagePath,
            'LinkUrl' => $validated['LinkUrl'] ?? null,
            'Urutan' => $validated['Urutan'] ?? $banner->Urutan,
            'IsActive' => $request->boolean('IsActive'),
            'UserUpdate' => auth()->user()?->name,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Banner berhasil diperbarui.',
            'data' => $banner,
        ]);
    }

    public function destroy($id)
    {
        $banner = NewsBanner::find($id);
        if (!$banner) {
            return response()->json(['status' => 404, 'message' => 'Data tidak ditemukan.'], 404);
        }

        if ($banner->ImagePath && Storage::disk('public')->exists($banner->ImagePath)) {
            Storage::disk('public')->delete($banner->ImagePath);
        }
        $banner->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Banner berhasil dihapus.',
        ]);
    }
}
