<?php

namespace App\Http\Controllers;

use App\Models\SecurityTier;
use App\Support\IconHelper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SecurityTierController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:homepage.view')->only(['index']);
        $this->middleware('permission:homepage.create')->only(['create', 'store']);
        $this->middleware('permission:homepage.edit')->only(['edit', 'update']);
        $this->middleware('permission:homepage.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SecurityTier::with('translations')->orderBy('Urutan', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('NomorTier', function ($row) {
                    return '<span class="badge badge-primary px-2 py-1 font-weight-bold">' . e($row->NomorTier ?? '-') . '</span>';
                })
                ->addColumn('Icon', function ($row) {
                    if ($row->Icon) {
                        if (IconHelper::isFontAwesome($row->Icon)) {
                            return '<i class="' . e($row->Icon) . ' fa-2x text-primary" title="' . e($row->Icon) . '"></i>';
                        }
                        if (Storage::disk('public')->exists($row->Icon)) {
                            $url = asset('storage/' . $row->Icon);
                            return '<img src="' . $url . '" alt="Icon" style="height:35px; max-width:50px; object-fit:contain;" onerror="this.onerror=null; this.parentElement.innerHTML=\'<i class=\\\'fa fa-shield-alt fa-2x text-primary\\\'></i>\';">';
                        }
                    }
                    return '<i class="fa fa-shield-alt fa-2x text-primary" title="Default Icon"></i>';
                })
                ->addColumn('Judul', function ($row) {
                    $idTrans = $row->translations->firstWhere('Locale', 'id');
                    return $idTrans && $idTrans->Judul ? '<strong>' . e($idTrans->Judul) . '</strong>' : '<span class="text-muted">-</span>';
                })
                ->addColumn('Deskripsi', function ($row) {
                    $idTrans = $row->translations->firstWhere('Locale', 'id');
                    if (!$idTrans || !$idTrans->Deskripsi) return '<span class="text-muted">-</span>';
                    return Str::limit(e($idTrans->Deskripsi), 80);
                })
                ->addColumn('SubFitur', function ($row) {
                    $idTrans = $row->translations->firstWhere('Locale', 'id');
                    if ($idTrans && !empty($idTrans->Features) && is_array($idTrans->Features)) {
                        $items = [];
                        foreach ($idTrans->Features as $f) {
                            $t = e($f['t'] ?? '');
                            $d = e(Str::limit($f['d'] ?? '', 40));
                            $items[] = '<small class="d-block text-muted mb-1"><i class="fa fa-check text-success mr-1"></i><strong>' . $t . '</strong>: ' . $d . '</small>';
                        }
                        return implode('', $items);
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->addColumn('status', function ($row) {
                    return $row->Status
                        ? '<span class="badge badge-success px-2 py-1">Aktif</span>'
                        : '<span class="badge badge-secondary px-2 py-1">Tidak Aktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';
                    if (auth()->user()->can('homepage.edit')) {
                        $btn .= '<a href="' . route('security-tier.edit', $row->id) . '" class="btn btn-warning" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>';
                    }
                    if (auth()->user()->can('homepage.delete')) {
                        $btn .= '<button class="btn btn-danger btn-delete-tier" data-id="' . $row->id . '" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['NomorTier', 'Icon', 'Judul', 'Deskripsi', 'SubFitur', 'status', 'action'])
                ->make(true);
        }

        return view('pages.admin.security-tier.index');
    }

    public function create()
    {
        return view('pages.admin.security-tier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NomorTier' => 'required|string|max:20',
            'Icon' => 'required|string|max:150',
            'Urutan' => 'required|integer|min:0',
            'Status' => 'required|boolean',

            'translations.id.Judul' => 'required|string|max:255',
            'translations.id.Deskripsi' => 'required|string',
            'translations.id.features' => 'nullable|array',
            'translations.id.features.*.t' => 'nullable|string|max:255',
            'translations.id.features.*.d' => 'nullable|string|max:255',

            'translations.en.Judul' => 'nullable|string|max:255',
            'translations.en.Deskripsi' => 'nullable|string',
            'translations.en.features' => 'nullable|array',
            'translations.en.features.*.t' => 'nullable|string|max:255',
            'translations.en.features.*.d' => 'nullable|string|max:255',
        ]);

        $iconValue = IconHelper::sanitizeClass($request->input('Icon'));
        if ($iconValue === null) {
            return back()->withInput()->withErrors(['Icon' => 'Format class icon FontAwesome tidak valid.']);
        }

        $tier = SecurityTier::create([
            'NomorTier' => $request->NomorTier,
            'Icon' => $iconValue,
            'Urutan' => $request->Urutan,
            'Status' => $request->Status,
        ]);

        foreach (['id', 'en'] as $locale) {
            if (!empty($validated['translations'][$locale]['Judul'])) {
                $features = [];
                if (!empty($validated['translations'][$locale]['features'])) {
                    foreach ($validated['translations'][$locale]['features'] as $f) {
                        if (!empty($f['t']) || !empty($f['d'])) {
                            $features[] = [
                                't' => $f['t'] ?? '',
                                'd' => $f['d'] ?? '',
                            ];
                        }
                    }
                }

                $tier->translations()->create([
                    'Locale' => $locale,
                    'Judul' => $validated['translations'][$locale]['Judul'],
                    'Deskripsi' => $validated['translations'][$locale]['Deskripsi'] ?? null,
                    'Features' => $features,
                ]);
            }
        }

        if (function_exists('activity')) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($tier)
                ->log('Membuat data lapisan keamanan: ' . ($validated['translations']['id']['Judul'] ?? ''));
        }

        return redirect()->route('homepage.index')->with('success', 'Data lapisan keamanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = SecurityTier::with('translations')->findOrFail($id);
        return view('pages.admin.security-tier.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'NomorTier' => 'required|string|max:20',
            'Icon' => 'nullable|string|max:150',
            'Urutan' => 'required|integer|min:0',
            'Status' => 'required|boolean',

            'translations.id.Judul' => 'required|string|max:255',
            'translations.id.Deskripsi' => 'required|string',
            'translations.id.features' => 'nullable|array',
            'translations.id.features.*.t' => 'nullable|string|max:255',
            'translations.id.features.*.d' => 'nullable|string|max:255',

            'translations.en.Judul' => 'nullable|string|max:255',
            'translations.en.Deskripsi' => 'nullable|string',
            'translations.en.features' => 'nullable|array',
            'translations.en.features.*.t' => 'nullable|string|max:255',
            'translations.en.features.*.d' => 'nullable|string|max:255',
        ]);

        $tier = SecurityTier::findOrFail($id);

        $oldIcon = $tier->Icon;
        if (!$request->exists('Icon')) {
            $iconValue = $oldIcon;
        } else {
            $rawIcon = trim((string) $request->input('Icon', ''));
            if ($rawIcon === '') {
                $iconValue = null;
            } elseif ($rawIcon === (string) $oldIcon && !IconHelper::isFontAwesome($oldIcon)) {
                $iconValue = $oldIcon;
            } else {
                $iconValue = IconHelper::sanitizeClass($rawIcon);
                if ($iconValue === null) {
                    return back()->withInput()->withErrors(['Icon' => 'Format class icon FontAwesome tidak valid.']);
                }
            }
        }

        if ($iconValue !== $oldIcon && $oldIcon && !IconHelper::isFontAwesome($oldIcon) && Storage::disk('public')->exists($oldIcon)) {
            Storage::disk('public')->delete($oldIcon);
        }

        $tier->update([
            'NomorTier' => $request->NomorTier,
            'Icon' => $iconValue,
            'Urutan' => $request->Urutan,
            'Status' => $request->Status,
        ]);

        foreach (['id', 'en'] as $locale) {
            $features = [];
            if (!empty($request->input("translations.{$locale}.features"))) {
                foreach ($request->input("translations.{$locale}.features") as $f) {
                    if (!empty($f['t']) || !empty($f['d'])) {
                        $features[] = [
                            't' => $f['t'] ?? '',
                            'd' => $f['d'] ?? '',
                        ];
                    }
                }
            }

            $tier->translations()->updateOrCreate(
                ['Locale' => $locale],
                [
                    'Judul' => $request->input("translations.{$locale}.Judul"),
                    'Deskripsi' => $request->input("translations.{$locale}.Deskripsi"),
                    'Features' => $features,
                ]
            );
        }

        if (function_exists('activity')) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($tier)
                ->log('Mengupdate data lapisan keamanan: ' . ($request->input('translations.id.Judul') ?? ''));
        }

        return redirect()->route('homepage.index')->with('success', 'Data lapisan keamanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $item = SecurityTier::findOrFail($id);
            if ($item->Icon && !IconHelper::isFontAwesome($item->Icon) && Storage::disk('public')->exists($item->Icon)) {
                Storage::disk('public')->delete($item->Icon);
            }
            $item->delete();
            return response()->json(['success' => true, 'message' => 'Data lapisan keamanan berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
